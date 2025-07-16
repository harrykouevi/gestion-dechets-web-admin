<?php

namespace App\Livewire;

use App\Services\QuizService;
use Livewire\Component;
use App\Services\RewardService;
use Livewire\WithFileUploads;

class RewardForm extends Component
{
    use WithFileUploads;

    public $reward_quizzId;
    public $quizz;
    public $reward;
    public $rewardId = Null;
    public $reward_name ;
    public $reward_value ;
    public $reward_description;
    public $reward_type = "points";
    public $reward_badge_title ;
    public $reward_image_file ;
    public $requestontheway = false ;
    public $successMessage = Null ;

    private RewardService $rewardService;

    public function mount(RewardService $rewardService ,$quizzId = null, $id = null)
    {
        $this->rewardService = $rewardService;

        if ($id) {
            $this->loadExistingReward($id);
        } else {
            $this->initializeNewReward($quizzId);
        }
        
    }

    protected function loadExistingReward($id)
    {
        $this->reward = $reward = $this->rewardService->get($id, ['quizz']);
        // $this->reward_quizzId = $reward['quizzId'];
        $this->rewardId = $reward['id'];
        $this->reward_name = $reward['name'];
        $this->reward_description = $reward['description'];
        $this->reward_value = $reward['value'];
   
    }

    protected function initializeNewReward($quizzId)
    {
        if (is_null($quizzId)) {
            $this->addError('reward_quizzId', 'Le quizzId est requis pour créer un nouvelle recompense.');
            return;
        }

        $this->reward_quizzId = $quizzId; 
        $this->quizz = $this->getQuiz();

       
    }


    public function save()
    {
        $this->resetErrorBag();
        $data_v = $this->validate([
                'reward_quizzId' => 'sometimes',
                'reward_name' => 'required|string|max:255',
                'reward_value' => 'required',
                'reward_description' => 'required|string|max:255',
                'reward_type' => 'required|string',
                'reward_badge_title' => 'nullable|string',
                'reward_image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],[
                'reward_name.required' => 'The name field is required.',
                'reward_description.required' => 'The description field is required.',
                'reward_type.required' => 'The type field is required.',
            ]
        );

        $data = [
            'quizz_id' => $data_v['reward_quizzId'] ?? null,
            'name' => $data_v['reward_name'],
            'value' => $data_v['reward_value'],
            'description' => array_key_exists('reward_description',$data_v)? $data_v['reward_description'] : Null ,
            'type' => $data_v['reward_type'],
            'badge_title' => $data_v['reward_badge_title'],
            
        ];

        $image =  $data_v['reward_image_file'] ?? null ;



        try{ 
            $response = $this->rewardId
                ? app(RewardService::class)->update($this->rewardId, $data)
                : app(RewardService::class)->create($data , $image);
            $this->requestontheway = false ;
            if (isset($response['errors'])) {
                $this->handleErrors($response['errors']);
            } elseif (isset($response['success']) && $response['success']) {
                $this->successMessage = 'Opération réussie !';
                session()->flash('success', $this->successMessage);

                if (!$this->rewardId) {
                    return redirect()->route('rewards.edit', ['id' => $response['data']['id']]);
                }
            }
          
        }catch (\Exception $e) {
            $this->requestontheway = false ;
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }


    protected function handleErrors(array $errors)
    {
        
        foreach ($errors as $field => $messages) {
            if (is_string($messages)) {
                foreach (['id','titre', 'description','passing score', 'nombre question', 'quizz id'] as $needle) {
                    if (str_contains($messages, $needle)) {
                        $this->addError('reward_'. str_replace(' ', '_', $needle), str_replace("Validation Error:", '', $messages));
                    }
                }

                foreach (['questions.'] as $needle) {
                    preg_match('/' . preg_quote($needle, '/') . '[\w\d_.]+/', $messages, $matches);
                    if (!empty($matches)) {
                        $this->addError('reward_'. $matches[0], str_replace("Validation Error:", '', $messages));
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

    public function getQuiz()
    {
        return  app(QuizService::class)->get($this->reward_quizzId,['true']) ;
    }

    public function render()
    {
        return view('livewire.reward-form');
    }
}
