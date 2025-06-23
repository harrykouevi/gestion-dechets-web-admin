<?php

namespace App\Livewire;

use App\Services\PostService;
use Livewire\Component;

class ListOfPosts extends Component
{
    public string $mode = 'incident';
   
    public $urlparams = [] ;
    public ?string $endpoint = '';

    public $selectedPost = null;

    public ?string $filterType = null;
    public ?string $filterStatus = null;

    public ?float $incidentLatitude = null;
    public ?float $incidentLongitude = null;
    public ?float $incidentRadius = null;

    // Dans ton composant Livewire
    public $postIdToDelete = null;

    public ?float $departureLatitude = null;
    public ?float $departureLongitude = null;
    public ?float $arrivalLatitude = null;
    public ?float $arrivalLongitude = null;

    public $successMessage = Null ;
    private PostService $postService;

    public function mount(PostService $postService)
    {
        $this->postService = $postService;
  
        // Au départ, pas de filtres appliqués
        // $this->appliedFilters = [
        //     'per_page' => 20
        // ];
    }

    public function setPostIdToDelete($id)
    {
        $this->postIdToDelete = $id;
    }


    public function applyFilters()
    {
        if ($this->mode === 'incident') {
            // Appliquer les filtres incidents
            $this->urlparams = [
               
                'lat' => $this->incidentLatitude,
                'lng' => $this->incidentLongitude,
                'radius' => $this->incidentRadius,
            ];


            $this->endpoint = route('map-incidents') ;

            //lat=6.1751&lng=1.2123&radius=1000
        } elseif ($this->mode === 'itineraire') {
            // Appliquer la recherche d'itinéraire
            $this->urlparams = [
               
                'start' => $this->departureLatitude.','.$this->departureLongitude,
                'end' => $this->arrivalLatitude.','.$this->arrivalLongitude,
                'alternatives' => 3,
            ];


            $this->endpoint = route('map-directions') ;
            //start=6.1725,1.2314&end=6.1865,1.2200&alternatives=3
        }
        $this->updateIframeUrl();
    }

    public function selectPost($id){
        // $this->selectedPost = (new RoadissueService())->get($id) ;
        // $this->urlparams = [
               
        //         'lat' => $this->selectedPost["latitude"],
        //         'lng' => $this->selectedPost["longitude"],
        //         'radius' => 1,
        // ];


        // $this->endpoint = route('map-incidents') ;
        $this->selectedPost = $id;

    }

    
    public function delete(){
        $this->resetErrorBag();
        $postService = app(PostService::class);
      

        try{ 
            // $data = [
            //     'titre' => $data_v['post_titre'],
            //     'description' => array_key_exists('post_description',$data_v)? $data_v['post_description'] : Null ,
            //     'content' => $data_v['post_content'],
            //     'type' => $data_v['post_type'],
            // ];
            if ($this->postIdToDelete) {
                $response = $postService->delete($this->postIdToDelete) ; 
           
                if (isset($response['errors'])) {
                    $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                    foreach ($response['errors'] as $field => $messages) {
                        if(is_string($messages)){
                            foreach (['id','titre', 'content','type','description'] as $needle) {
                                if (str_contains($messages, $needle)) {
                                    $this->addError('post_'.$needle, str_replace("Validation Error:", '', $messages));
                                }
                            }
                        }
                        foreach ((array)$messages as $message) {
                            $this->addError($field, $message);
                        }
                    }
                    
                }

                if (isset($response['success']) && $response['success'] == true) {
                    $this->successMessage = "Opération réussie !";
                    $this->reset('postIdToDelete');
                    // Déclenche l’événement JS
                    $this->dispatch('post-deleted');
                    // return redirect()->route('posts.index');
                }
            }
            
          
            
        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    


    public function loadList()
    {
        return  app(PostService::class)->getAll(['quizz']) ;
    }

 
    public function render()
    {
        $posts = $this->loadList() ;
        return view('livewire.list-of-posts', [
            'datas' => $posts,
        ]);
    }
}
