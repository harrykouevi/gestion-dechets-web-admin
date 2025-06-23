<?php

namespace App\Livewire;

use App\Services\PostService;
use Livewire\Component;

class PostForm extends Component
{
    public $post;
    public $postId;
    public $post_titre ;
    public $post_content;
    public $post_description;
    public $post_type = "educatif";
    

    public $successMessage = Null ;

    private PostService $postService;

    public function mount(PostService $postService , $id = null)
    {
        $this->postService = $postService;
        if ($id) {
            $this->post = $post = $this->postService->get($id) ;
            $this->postId = $post['id'];
            $this->post_titre = $post['titre'];
            $this->post_content = $post['content'] ;
            $this->post_description = in_array('description',$post)? $post['description'] : "" ;
            $this->post_type = $post['type'] ;
        }
    }

    public function save()
    {
        $this->resetErrorBag();
        $postService = app(PostService::class);
         $this->dispatch('savedff');
        $data_v = $this->validate([
                'post_titre' => 'required|string|max:255',
                'post_content' => 'required|string',
                'post_description' => 'required|string|max:255',
                'post_type' => 'required',
            ],[
                'post_titre.required' => 'The titre field is required.',
                'post_content.required' => 'The content field is required.',
                'post_description.required' => 'The description field is required.',
                'post_type.required' => 'The type field is required.',
            ]
        );

        try{ 
            

            $data = [
                'titre' => $data_v['post_titre'],
                'description' => array_key_exists('post_description',$data_v)? $data_v['post_description'] : Null ,
                'content' => $data_v['post_content'],
                'type' => $data_v['post_type'],
            ];
            if ($this->postId) {
                $response = $postService->update($this->postId,$data) ; 
            } else {
                $response = $postService->create($data) ; 
            }
            
          
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
                session()->flash('success', 'Opération réussie !');
                $this->successMessage = "Opération réussie !";
                return redirect()->route('posts.edit',['id'=>$response['data']['id']]);
            }
        }catch (\Exception $e) {
        

            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }


    public function render()
    {
        return view('livewire.post-form');
    }
}
