<div>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-success">🏆 Top 10 des meilleurs scores aux quizzes</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Utilisateur</th>
                        <th>Quiz</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topScores as $index => $attempt)
                        <tr>
                            <td>{{ $index + 1}}</td>
                            <td>{{ array_key_exists("nom", $attempt ) ?  $attempt['nom'].' '.$attempt['prenom'] : 'nom' }}</td>
                            <td>{{ array_key_exists("quizz_id", $attempt ) ?  $attempt['quizz_id'] : 'quiz' }}</td>
                            <td>@if(array_key_exists("best_score", $attempt ))  <strong> <a href="{{ route('quizzes.results.show', ['user' => $attempt['user_id'], 'quiz' => $attempt['quizz_id'] ]) }}"  class="text-bold  text-primary">  {{ $attempt['best_score'] }} </a> </strong> @else 'score' @endif</td>
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
