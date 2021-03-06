@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <form action="{{ url('users/create') }}" method="GET">{{ csrf_field() }}
                                <button type="submit" id="create-user" class="btn btn-primary"><i
                                            class="fa fa-btn fa-file-o"></i>Create
                                </button>
                            </form>
                        </div>
                        <div><h4>Users Information</h4></div>
                    </div>
                    <div class="panel-body">
                        @if (count($users) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped cds-datatable">
                                    <thead> <!-- Table Headings -->
                                    {{--<th>User</th><th>Email</th><th>Status</th><th class="no-sort">Actions</th>--}}
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody> <!-- Table Body -->
                                    @foreach ($users as $user)
                                        <tr>
                                            <!-- get the logged in user's user id and disable edit functionality of his/her profile -->
                                            @if ($user->id == Auth::user()->getUserId())
                                                <td class="table-text">
                                                    <div>{{ $user->f_name }} {{  $user->m_name }} {{  $user->l_name }}</div>
                                                </td>
                                                <td class="table-text">
                                                    <div>{{ $user->email }}</div>
                                                </td>
                                            @else
                                                <td class="table-text">
                                                    <div>
                                                        <a href="{{ url('/users/'.$user->id.'/edit') }}">{{ $user->f_name }} {{  $user->m_name }} {{  $user->l_name }}</a>
                                                    </div>
                                                </td>
                                                <td class="table-text">
                                                    <div>{{ $user->email }}</div>
                                                </td>
                                            @endif
                                            @if ($user->active)
                                                <td class="table-text">
                                                    <div>Active</div>
                                                </td>@else
                                                <td class="table-text">
                                                    <div>Inactive</div>
                                                </td>@endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="panel-body"><h4>No User Records found</h4></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

