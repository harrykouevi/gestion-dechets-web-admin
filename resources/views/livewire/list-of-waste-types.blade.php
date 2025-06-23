<div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="incidentTypesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Gravité</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wastetype as $type)
                        <tr>
                            <td>{{ array_key_exists("id", $type ) ?  $type['id'] : 1}}</td>
                            <td>{{ array_key_exists("name", $type ) ?  $type['name'] : 'name' }}</td>
                            <td>{{ array_key_exists("description", $type ) ?  $type['description'] : 'description'}}</td>
                            <td>
                                <span class="badge " style="background:{{ array_key_exists("type", $type ) ?  $type['color'] : 'rouge' }} ">
                                    {{ ucfirst(array_key_exists("color", $type ) ?  $type['color'] : 'rouge') }}
                                </span> 
                                {{-- <span class="badge badge-{{ $type->severity === 'élevée' ? 'danger' : ($type->severity === 'moyenne' ? 'warning' : 'success') }}">
                                    {{ ucfirst($type->severity) }}
                                </span>  --}}
                            </td>
                            <td>{{ array_key_exists("created_at", $type ) ?  $type['created_at'] : 2025-05-13 }}</td>
                            <td>
                                <a href="{{-- route('incident-types.edit', $type->id) --}}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{-- route('incident-types.destroy', $type->id) --}}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce type ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

</div>
