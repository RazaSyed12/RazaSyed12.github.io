<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $students=Student::latest()->paginate(5);
        return view('students.index',compact('students'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'

        ]);
        $name = time().$request->file('image')->getClientOriginalName();
        $folder = public_path().'\images';
        $request->image->move($folder, $name);

        $student = Student::create($request->all());
        $student->update(['image' => $name ]);
       
        return redirect()->route('students.index')
                        ->with('success','Student Profile created successfully.');
    }
 
    /**
     * Display the specified resource.
     */
    public function show(Student $student):View
    {
        return view('students.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student):View
    {
        return view('students.edit',compact('student'));
    }

    public function __construct()
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'image' => 'required'

        ]);
        $this->deleteOldImage($student->image);
        $name = time().$request->file('image')->getClientOriginalName();
        $folder = public_path().'\images';
        $request->image->move($folder, $name);

        $student->update($request->all());
        $student->update(['image' => $name ]);

      
        return redirect()->route('students.index')
                        ->with('success','Student Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();
       
        return redirect()->route('students.index')
                        ->with('success','Student Profile deleted successfully');
    }

    protected function deleteOldImage($image)
    {
    if ($image){
        $folder = public_path()."/images/";
        unlink($folder.$image);
      }
    }
}

