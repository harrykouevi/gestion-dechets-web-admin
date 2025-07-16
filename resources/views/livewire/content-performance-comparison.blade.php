<div>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-info">📊 Comparaison des performances des contenus éducatifs</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Contenu</th>
                        <th>Quiz associé</th>
                        <th>Tentatives</th>
                        <th>Moyenne Score</th>
                        <th>Taux de Réussite</th>
                    </tr>
                </thead>
                <tbody wire:poll.5s>
                    @forelse ($contents as $item)
                        <tr>
                            <td>@if( array_key_exists("postId", $item ))  <a href="{{ route('posts.edit',['id'=>$item['postId']]) }}" class="text-bold text-dark">  {{ $item['postId'] }} </a>  @else title @endif</td>
                            <td>@if(array_key_exists("titre", $item ) ) <a href="{{ route('quizzes.edit',['id'=>$item['id']]) }}" class="text-bold text-primary">  {{ $item['titre']}} </a> @else title @endif</td>
                            <td>{{ $stats[$item['id']]['attempts'] ?? 'Chargement...' }}</td>
                            <td>{{ $stats[$item['id']]['average_score'] ?? 'Chargement...' }}
                                <div wire:loading wire:target="stats.{{ $item['id'] }}.average_score" class="text-info">Chargement …</div>
                            </td>
                            <td>{{ $stats[$item['id']]['success_rate'] ?? 'Chargement...' }} %</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune donnée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
</div>
