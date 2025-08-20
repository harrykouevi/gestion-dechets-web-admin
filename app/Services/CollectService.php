<?php

namespace App\Services;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CollectService
{
    use ServiceTrait ;

    public function getAll(Array $param_ = [], int $perPage = null )
    {
        $params = [...$param_];
        if (!empty($relation)) $params['with_relations'] = implode(',', $relation);

        if (!is_null($perPage)) $params['per_page'] = $perPage;

        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/collectes/get', $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            return collect($data);
        }

        abort(404, 'Erreur lors de la récupération des posts.');
    }

    /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @return array
     * @throws \Exception
     * /collecteur/count'
     */
    public function getCount(string $dechet_id) : int
    {
        $params["dechet_id"] = $dechet_id ;

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/collectes/count', $params);


        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération ');
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
        if (!empty($relation)) $params['with_relations'] = 'true';

        // $cached_data = Cache::get("post_{$id}") ;
        // if(!is_null($cached_data)){
        //     return $cached_data;
        // }

        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/collectes/get/'.$id, $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            Cache::put("post_{$id}", $data, now()->addMinutes(5));
            return $data;
        }

        // Gérer les erreurs ici
        abort(404, 'Erreur lors de la récupération des posts.');
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

        $endpoint = env('API_SERVICE_URL') . "/api/collectes/create";

        $response = $http->post($endpoint, $data);

        if ($response->successful()) {
            $data = $response->json()['data'];
            // Cache::put("post_{$data['id']}", $data, now()->addMinutes(5));
        }

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


        $response = $http->post(env('API_SERVICE_URL') . "/api/collectes/update/".$id, $data);
        if ($response->successful()) {
            $data = $response->json()['data'];
            // Cache::put("post_{$data['id']}", $data, now()->addMinutes(5));
        }

        return $this->render($response);
    }

    public function delete($id)
    {
        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->delete(env('API_SERVICE_URL') . "/api/collectes/delete/".$id);

        if ($response->successful()) {
            // Cache::forget("post_{$id}");
        }

        return $this->render($response);
    }


}
