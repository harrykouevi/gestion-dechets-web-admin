<?php

namespace App\Livewire;

use App\Services\PostService;
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
    

    public $successMessage = Null ;

    private QuizService $quizzService;

    public function mount(QuizService $quizzService ,$postId = null, $id = null)
    {
        $this->quizzService = $quizzService;
        if ($id) {
            $this->quizz = $quizz = $this->quizzService->get($id,['post']) ;
            
            $this->quizz_postId = $quizz['postId'] ;
            $this->quizzId = $quizz['id'];
            $this->quizz_titre = $quizz['titre'];
            $this->quizz_passing_score = $quizz['passing_score'] ?? 0;
            $this->quizz_nombre_question = $quizz['nombre_question'] ?? 1;

            $this->quizz_questions = $quizz['questions'] ;

            // $this->quizz_description = $quizz['description'] ?? '';
            // $this->quizz_type = $quizz['type'] ;
            foreach($quizz['questions'] as $q_key => $question ){
                $this->quizz_questions[$q_key]['type'] = $question['type'] ?? "single_choice";
                foreach($question['reponses'] as $r_key => $reponse ){
                }
            }
        }else {
            if (is_null($postId)) {
                $this->addError('quizz_postId', 'Le postId est requis pour créer un nouveau quiz.');
                return; // on stoppe ici pour éviter d’aller plus loin
            }
            $this->quizz_postId = $postId;

            $this->post = $this->getPost();
            if(!is_null($this->post['quizz'] )){
                return redirect()->route('quizzes.edit',['id'=>$this->post['quizz']['id']]);
                
            }

            
        }
        
    }

    public function addPropositions($id)
    {
        if (count($this->quizz_questions[$id]["reponses"]) >= 5) {
            $this->addError('propositions', 'Tu ne peux pas ajouter plus de 5 propositions.');
            return;
        }

        $this->quizz_questions[$id]["reponses"][] = [
            'texte' => '',        // ou 'value' => '', etc.
            'is_correct' => false // ou tout autre champ que tu utilises
        ]; ;
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
        if (count($this->quizz_questions) >= 5) {
            $this->addError('questions', 'Tu ne peux pas ajouter plus de 5 questions');
            return;
        }

        $this->quizz_questions[] =  ["reponses"  => [null]];
    }


    public function saveQuiz()
    {
        $this->resetErrorBag();
        $quizzService = app(QuizService::class);
        // $this->dispatch('savedff');
        $data_v = $this->validate([
                'quizz_postId' => 'required',
                'quizz_titre' => 'required|string|max:255',
                'quizz_passing_score' => 'required',
                'quizz_nombre_question' => 'required',
                // 'quizz_type' => 'required|string',
                'quizz_type' => 'required',
                'quizz_questions'=> 'required|array|min:1',
                'quizz_questions.*.type'=> 'required|string',
                'quizz_questions.*.texte'=> 'required|string',
                'quizz_questions.*.reponses'=> 'array',
                'quizz_questions.*.reponses.*.texte'=> 'required|string',
                'quizz_questions.*.reponses.*.isCorrect'=> 'nullable|boolean',
            ],[
                'quizz_titre.required' => 'The titre field is required.',
                'quizz_content.required' => 'The content field is required.',
                'quizz_description.required' => 'The description field is required.',
                'quizz_type.required' => 'The type field is required.',
            ]
        );

        try{ 
            // dd($data_v['quizz_questions']) ;
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

            
          
            if ($this->quizzId) {
                $response = $quizzService->update($this->quizzId,$data) ; 
            } else {
                $response = $quizzService->create($data) ; 
            }
            
          
            if (isset($response['errors'])) {
                $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                foreach ($response['errors'] as $field => $messages) {
                    if(is_string($messages)){
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
                    foreach ((array)$messages as $message) {
                        $this->addError($field, $message);
                    }
                }
                
            }
        

            if (isset($response['success']) && $response['success'] == true) {
                session()->flash('success', 'Opération réussie !');
                $this->successMessage = "Opération réussie !";
                if ($this->quizzId) {
                }else{
                    return redirect()->route('quizzes.edit',['id'=>$response['data']['id']]);
                }
            }
        }catch (\Exception $e) {
        

            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
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
