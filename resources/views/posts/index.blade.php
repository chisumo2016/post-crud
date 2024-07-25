@extends('layouts.master')

@section('content')
    <div class="main-content mt-3">
        <div class="card">
            <div class="card-header">
                All Posts

                <a href="" class="btn btn-success">Create post</a>
                <a href="" class="btn btn-warning">Trashed</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 10%;">Title</th>
                        <th scope="col" style="width: 10%;">Image</th>
                        <th scope="col" style="width:  30%;">Description</th>
                        <th scope="col" style="width: 10%;">Category</th>
                        <th scope="col" style="width: 10%;">Publish Date</th>
                        <th scope="col" style="width: 10%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Lorem ipsum </td>
                        <td>
                            <img src="https://picsum.photos/200" alt="" width="80">
                        </td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda dolor est eveniet hic inventore iure laudantium minus nesciunt praesentium provident, quibusdam quis,</td>
                        <td>News</td>
                        <td>2-5-2023</td>
                        <td>
                            <a href="" class="btn btn-primary btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
