<?php

namespace App\Services;

use App\Models\FeaturedUser;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PostService
{
    use ServiceTrait ;
    
    public function getAll(Array $relation = [], int $perPage = null )
    {
        $params = [];
        // if (!empty($relation)) $params['with_relations'] = implode(',', $relation);
        if (!empty($relation)) $params['with_relations'] = 'true';
        if (!is_null($perPage)) $params['per_page'] = $perPage;
       
        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/blogs/post', $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            return collect($data);
        }

        // Gérer les erreurs ici
        throw new \Exception('Erreur lors de la récupération des posts');
    }
    

    public function search(String $search , Array $relation = [], int $perPage = Null)  {
        // Query annonces with pagination, optionally filtering by search term
        $annonce_builder = User::where('titre', 'like', '%' . $search . '%')
                ->where('titre', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('adresse', 'LIKE', "%{$search}%")
                ->orWhere('prix', 'LIKE', "%{$search}%")
                ->orWhere('surface', 'LIKE', "%{$search}%")
                ->orWhere('wcdouche', 'LIKE', "%{$search}%")
                ->orWhere('nbpieces', 'LIKE', "%{$search}%")
                ->orWhere('nbsalon', 'LIKE', "%{$search}%")
                ->orWhereHas('Category', function ($query) use ($search) {
                    $query->where('nom', 'LIKE', "%{$search}%");
                }) ;

        if(!empty($relation)){
            $annonce_builder = $this->getRelation( $annonce_builder,$relation) ;
        }
        if($perPage){
            return  $annonce_builder->paginate($perPage);
        } else {
            return  $annonce_builder->get() ;
        }
    }

  
    public function get($id,Array $relation=[])
    {
        $params = [];
        // if (!empty($relation)) $params['with_relations'] = implode(',', $relation);
        if (!empty($relation)) $params['with_relations'] = 'true';
        
        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/blogs/post/'.$id, $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            return $data;
        }

        // Gérer les erreurs ici
        throw new \Exception('Erreur lors de la récupération des posts');
    }

    

    public function create(array $data, $mediaFiles  = [])
    {
        $data['admin_id'] = session('user')['id'];

        $http = Http::withToken(session('token'))
          ->asMultipart() // Nécessaire pour les fichiers
                    ->withHeaders(['Accept' => 'application/json']);
       
        
        foreach ($mediaFiles as $index => $media) {
            if (!empty($media['file'])) {
                $http = $this->attachFileToHttp($http, "medias[$index][file]", $media['file']);
            }
        
            $data["medias[$index][type]"] = 'image';
            if (isset($media['type'])) {
                $data["medias[$index][type]"] = $media['type'];
            }
        }
       
        $endpoint = $data['type'] === 'educatif'
            ? env('API_SERVICE_URL') . "/api/blogs/post/educatif"
            : env('API_SERVICE_URL') . "/api/blogs/post";

       
    
        $response = $http->post($endpoint, $data);
       
        return $this->render($response);
    }

    

    public function update(string $id, array $data , $mediaFiles  = [])
    {
        $data['admin_id']= session('user')['id'];
       
        $http = Http::withToken(session('token'))
          ->asMultipart() // Nécessaire pour les fichiers
                    ->withHeaders(['Accept' => 'application/json']);
       
         // Spoof de la méthode PATCH
        $http = $http->attach('_method', 'PATCH');

        foreach ($mediaFiles as $index => $media) {
            
            if (!empty($media['file'])) {
                $http = $this->attachFileToHttp($http, "medias[$index][file]", $media['file']);
            }
        
            $data["medias[$index][type]"] = 'image';
            if (isset($media['type'])) {
                $data["medias[$index][type]"] = $media['type'];
            }
        }

       
        $response = $http->post(env('API_SERVICE_URL') . "/api/blogs/post/update/".$id, $data);
       
        return $this->render($response);
    }

    public function delete($id)
    {
        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->delete(env('API_SERVICE_URL') . "/api/blogs/post/delete/".$id);

        return $this->render($response);
    }



    /**
     * Retirer un article à la une.
     *
     * @param int $annonceId
     */
    // public function removeFromFeatured($annonceId)
    // {
    //     $annonce = $this->get($annonceId);
    //     if(!is_null($annonce)){
    //     FeaturedUser::where('annonce_id', $annonceId)
    //     ->delete();}
    //     return true;
    // }


    // public function imgCreate(array $data)
    // {
    //     // Créer l'image et associer l'utilisateur connecté
    //     $image = new Image();
    //     $image->path = $data['path'];
    //     $image->annonce_id = $data['annonce_id'];
    //     $image->save();
    //     return $image ;
    // }

}
