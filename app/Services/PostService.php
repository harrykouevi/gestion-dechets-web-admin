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

    public function create(array $data) //Password125
    {
        $data['admin_id']= session('user')['id'];
        if(in_array('educatif',$data)){
            $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->post(env('API_SERVICE_URL') . "/api/blogs/post/educatif", $data);
        }else{
            $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->post(env('API_SERVICE_URL') . "/api/blogs/post", $data);
        }
        
        return $this->render($response);
        
    }

    public function update(string $id, array $data)
    {
        $data['admin_id']= session('user')['id'];
        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->patch(env('API_SERVICE_URL') . "/api/blogs/post/update/".$id, $data);
       
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
