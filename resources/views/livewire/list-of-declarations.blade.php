<div>
 
    <!-- DataTales Example -->
    <!-- Content Row -->
    {{-- <div class="card shadow mb-4">
     
        <div class="card-body"> --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Type de déchet</th>
                            <th>Adresse</th>
                            <th>Email</th>
                            <th>Agents</th>
                            <th>Date de soumission</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($declarations as $declaration)
                        <tr>
                            <td>{{ array_key_exists("type", $declaration ) ? $declaration["type"] :  'Déchets ménagers' }}</td>
                            <td>{{ array_key_exists("addresse", $declaration ) ? $declaration["addresse"] :  '123 Rue de la Paix, Lomé' }}</td>
                            <td>{{ array_key_exists("email", $declaration ) ? $declaration["email"] : 'i@example.com' }}</td>
                            <td>{{ array_key_exists("agent", $declaration ) ? $declaration["agent"]["identifiant"] : 'Logossou' }}</td>
                            <td>{{ array_key_exists("created_at", $declaration ) ? $declaration['created_at'] : '2025-05-13' }}</td>
                            {{-- <td>{{ $declaration['created_at']->format('d/m/Y') }}</td>
                             --}}
                            <td>{{ array_key_exists("created_at", $declaration ) ? $declaration['statut'] : 'En attente'}}</td>
                            <td>
                                <a href="{{-- route('users.show', $declaration->id) --}}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{-- route('users.edit', $declaration->id) --}}" class="btn btn-sm btn-warning">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        {{-- </div>
    </div> --}}

</div>
