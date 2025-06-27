<?php

namespace App\Livewire;

use App\Services\PostService;
use App\Services\QuestionService;
use App\Services\QuizService;
use Livewire\Component;

class QuizForm extends Component
{
    public $quizz_postId;
    public $post;
    public $quizz;
    public $quizzId = Null;
    public $quizz_titre ;

    public $quizz_description;
    public $quizz_type = "educatif";
    public $quizz_passing_score = 0;
    public $quizz_nombre_question = 1 ;
    public $quizz_questions = [] ;
    public $reward_to_add = [] ;
    public $requestontheway = false ;
    public $successMessage = Null ;

    private QuizService $quizzService;

    public function mount(QuizService $quizzService ,$postId = null, $id = null)
    {
        $this->quizzService = $quizzService;

        if ($id) {
            $this->loadExistingQuiz($id);
        } else {
            $this->initializeNewQuiz($postId);
        }
        
    }

    protected function loadExistingQuiz($id)
    {
        $this->quizz = $quizz = $this->quizzService->get($id, ['post']);
        $this->quizz_postId = $quizz['postId'];
        $this->quizzId = $quizz['id'];
        $this->quizz_titre = $quizz['titre'];
        $this->quizz_passing_score = $quizz['passingScore'] ?? 0;
        $this->quizz_nombre_question = $quizz['nombreQuestion'] ?? 1;
        $this->quizz_questions = $quizz['questions'];

        foreach ($quizz['questions'] as $q_key => $question) {
            $this->quizz_questions[$q_key]['type'] = $question['type'] ?? 'single_choice';
        }
    }

    protected function initializeNewQuiz($postId)
    {
        if (is_null($postId)) {
            $this->addError('quizz_postId', 'Le postId est requis pour créer un nouveau quiz.');
            return;
        }

        $this->quizz_postId = $postId;
        $this->addQuestion() ;
        $this->post = $this->getPost();

        if (!is_null($this->post['quizz'])) {
            return redirect()->route('quizzes.edit', ['id' => $this->post['quizz']['id']]);
        }
    }

    


    public function addReward()
    {
        if (count($this->reward_to_add) >= 5) {
            $this->addError('rewards', 'Tu ne peux pas ajouter plus de 5 récompenses.');
            return;
        }

        $this->reward_to_add[] = '';
    }


    public function addQuestion()
    {
        if (count($this->quizz_questions) >= $this->quizz_nombre_question) {
            $this->addError('questions', 'Tu ne peux pas ajouter plus de 5 questions');
            return;
        }

        $this->quizz_questions[] =  ["reponses"  => [['isCorrect' => false , 'points' => 0]],'points' => 0];
    }

    public function addPropositions($id)
    {
        
        if (count($this->quizz_questions[$id]["reponses"]) < 5) {
            $this->quizz_questions[$id]["reponses"][] = [
                'isCorrect' => false // ou tout autre champ que tu utilises
                , 'points' => 0
            ]; 
        }
        $this->addError('propositions', 'Tu ne peux pas ajouter plus de 5 propositions.');
        return;
    }

    public function updatedQuizzQuestions($value, $name)

    {
        // Vérifie si la clé correspond à un champ "points" d'une réponse
        // if (str_contains($name, 'quizz_questions.') && str_contains($name, '.reponses.') && str_contains($name, '.points')) {
        if ( str_contains($name, '.reponses.') && str_contains($name, '.points')) {
          
            $name = 'quizz_questions.'.$name ;
            
            // Extraire l'index de la question
            // preg_match('/quizz_questions\.(\d+)\.reponses\.(\d+)\.points/', $name, $matches);
            // preg_match('/.reponses\.(\d+)\.points/', $name, $matches);
            preg_match('/quizz_questions\.(\d+)\.reponses\.(\d+)\.points/', $name, $matches);
          
          
            if (isset($matches[1])) {
                $Index = (int) $matches[1];
                // dd($value, $name , $Index) ;

                $this->recalculateQuestionPoints($Index);
            }
        }
    }

    protected function recalculateQuestionPoints($Index)
    {
        $total = 0;
        if (!isset($this->quizz_questions[$Index]['reponses'])) {
            return;
        }
        foreach ($this->quizz_questions[$Index]['reponses'] as $reponse) {
            $points = isset($reponse['points']) && is_numeric($reponse['points']) ? (int)$reponse['points'] : 0;
            $total += $points;
        }
        $this->quizz_questions[$Index]['points'] = $total;
    }


    public function saveQuiz()
    {
        $this->resetErrorBag();
        $data_v = $this->validate([
                'quizz_postId' => 'required',
                'quizz_titre' => 'required|string|max:255',
                'quizz_passing_score' => 'required',
                'quizz_nombre_question' => 'required',
                'quizz_type' => 'required|string',
                'quizz_questions'=> 'required|array|min:1',
                'quizz_questions.*.type'=> 'required|string',
                'quizz_questions.*.texte'=> 'required|string',
                'quizz_questions.*.points'=> 'required|integer',
                'quizz_questions.*.reponses'=> 'array',
                'quizz_questions.*.reponses.*.points'=> 'required',

                'quizz_questions.*.reponses.*.texte'=> 'required|string',
                'quizz_questions.*.reponses.*.isCorrect'=> 'nullable|boolean',
            ],[
                'quizz_titre.required' => 'The titre field is required.',
                'quizz_content.required' => 'The content field is required.',
                'quizz_description.required' => 'The description field is required.',
                'quizz_type.required' => 'The type field is required.',
            ]
        );

        $data = [
            'titre' => $data_v['quizz_titre'],
            'passing_score' => $data_v['quizz_passing_score'],
            'nombre_question' => $data_v['quizz_nombre_question'],
            'description' => array_key_exists('quizz_description',$data_v)? $data_v['quizz_description'] : Null ,
            'type' => $data_v['quizz_type'],
            'questions'=> $data_v['quizz_questions'],
            'post_id'=> $data_v['quizz_postId'],
        ];

        foreach($data['questions'] as $q_key => $question ){
            foreach($question['reponses'] as $r_key => $reponse ){
                $data['questions'][$q_key]['reponses'][$r_key]['is_correct'] =   $reponse['isCorrect'] ?? false ;
            }
        }

        try{ 
            $response = $this->quizzId
                ? app(QuizService::class)->update($this->quizzId, $data)
                : app(QuizService::class)->create($data);
            $this->requestontheway = false ;
            if (isset($response['errors'])) {
                $this->handleErrors($response['errors']);
            } elseif (isset($response['success']) && $response['success']) {
                $this->successMessage = 'Opération réussie !';
                session()->flash('success', $this->successMessage);

                if (!$this->quizzId) {
                    return redirect()->route('quizzes.edit', ['id' => $response['data']['id']]);
                }
            }
          
        }catch (\Exception $e) {
            $this->requestontheway = false ;
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    public function saveQuestion($index)
    {   
       
        $this->resetErrorBag();
        $questionService = app(QuestionService::class);
       
        $validated = $this->validate([
                
            'quizz_questions.'.$index.'.type'=> 'required|string',
            'quizz_questions.'.$index.'.texte'=> 'required|string',
            'quizz_questions.'.$index.'.points'=> 'required',
            'quizz_questions.'.$index.'.reponses'=> 'array',
            'quizz_questions.'.$index.'.reponses.*.points'=> 'required|integer',

            'quizz_questions.'.$index.'.reponses.*.texte'=> 'required|string',
            'quizz_questions.'.$index.'.reponses.*.isCorrect'=> 'nullable|boolean',
        ]); // Validation abrégée ici pour clarté
            
        $validated = $validated['quizz_questions'][$index];
        $validated['quizz_id'] = $this->quizzId ;
          
        foreach ($validated['reponses'] as $r_key => $reponse) {
            $validated['reponses'][$r_key]['is_correct'] = $reponse['isCorrect'] ?? false;
        }

        try {
          
            
            $response = (isset($this->quizz_questions[$index]['id']) && $this->quizz_questions[$index]['id'] )
                ? app(QuestionService::class)->update( $this->quizz_questions[$index]['id'] , $validated)
                : app(QuestionService::class)->create($validated);
            $this->requestontheway = false ;

            if (isset($response['errors'])) {
                $this->handleErrors($response['errors']);
            } elseif (isset($response['success']) && $response['success']) {
                $this->successMessage = 'Opération réussie !';
                session()->flash('success', $this->successMessage);

                if (!isset($this->quizz_questions[$index]['id'])) {
                    return redirect()->route('quizzes.edit', ['id' => $this->quizzId]);
                }
            }
        } catch (\Exception $e) {
            $this->requestontheway = false ;
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }   
    }

    protected function handleErrors(array $errors)
    {
        
        foreach ($errors as $field => $messages) {
            if (is_string($messages)) {
                foreach (['id','titre', 'description','passing score', 'nombre question', 'post id'] as $needle) {
                    if (str_contains($messages, $needle)) {
                        $this->addError('quizz_'. str_replace(' ', '_', $needle), str_replace("Validation Error:", '', $messages));
                    }
                }

                foreach (['questions.'] as $needle) {
                    preg_match('/' . preg_quote($needle, '/') . '[\w\d_.]+/', $messages, $matches);
                    if (!empty($matches)) {
                        $this->addError('quizz_'. $matches[0], str_replace("Validation Error:", '', $messages));
                    }
                }
            }
            foreach ((array) $messages as $message) {
                $this->addError($field, $message);
            }

            if(is_int($field)){
                // dd($message);
                $this->addError('general_erreur', '<p >Une erreur est survenue</p><p class="text-xs font-weight-bold">'.$message.'</p>');
            }
        }
        $this->addError('general_erreur', '<p>Une erreur est survenue</p>');

    }

    public function getPost()
    {
        return  app(PostService::class)->get($this->quizz_postId,['quizz']) ;
    }

    public function render()
    {
        
        return view('livewire.quiz-form');
    }
}
