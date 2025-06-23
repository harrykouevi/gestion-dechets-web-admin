<div>
 
    {{-- <!-- DataTales Example -->
    <!-- Content Row -->
    <div class="card shadow mb-4">
     
        <div class="card-body"> --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    @if($showHeaders)
                    <thead>
                        <tr>
                            @if(!in_array('name', $columnsToNotShow)) <th>Nom</th> @endif
                            @if(!in_array('email', $columnsToNotShow)) <th>Email</th> @endif
                            @if(!in_array('created_at', $columnsToNotShow)) <th>Date d'inscription</th> @endif
                            {{-- <th>Rôle</th> --}}
                            @if($showActions) <th>Actions</th> @endif
                        </tr>
                    </thead>
                    @endif
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            @if(!in_array('name', $columnsToNotShow)) <td>{{ array_key_exists("name", $user ) ?   $user["name"] : 'nom et prenom' }}</td> @endif
                            @if(!in_array('email', $columnsToNotShow)) <td>{{ array_key_exists("email", $user ) ?  $user["email"] : 'admin@admin.com' }}</td> @endif
                            @if(!in_array('created_at', $columnsToNotShow)) <td>{{ array_key_exists("created_at", $user ) ?  $user['created_at'] : '2025-23-12'  }}</td> @endif
                            {{-- <td>{{ $user['created_at']->format('d/m/Y') }}</td>
                            <td>{{ $user->role ?? 'N/A' }}</td> --}}
                            @if($showActions)<td>
                                <a href="{{-- route('users.show', $user->id) --}}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{-- route('users.edit', $user->id) --}}" class="btn btn-sm btn-warning">Modifier</a>
                            </td>@endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        {{-- </div>
    </div> --}}

</div>
