@extends('students.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <br>
                <br>
                <h2>Student CRUD Example</h2>
            </div>
            <div class="pull-right">
                <br>
                <a class="btn btn-success" href="{{ route('students.create') }}"> Create New Student Profile</a>
                <br>
                <br>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>phone_number</th>
            <th>address</th>
            <th>image</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($students as $student)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $student->first_name }}</td>
            <td>{{ $student->last_name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->phone_number }}</td>
            <td>{{ $student->address }}</td>
            <td> 
                <img style="width: 150px; height: 150px" src= {{ asset("images/$student->image")}} alt="image"> 
            </td>

            <td>
                <form action="{{ route('students.destroy',$student->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('students.show',$student->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $students->links() !!}
      
@endsection
