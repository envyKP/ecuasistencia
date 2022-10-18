@extends('configCampanias.layoutMenu')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User List</div>
                    <div>
                        <a href="" style="float:right; margin-right:10px;">Create User</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-inverse">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>No</th>
                                    <th>No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Allcampanas as $item)
                                    <tr>
                                        <td>{{ $item->id_cliente }}</td>
                                        <td>{{ $item->cliente }}</td>
                                        <td>
                                            <a href="">Edit</a>
                                            |
                                            <a href="">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
