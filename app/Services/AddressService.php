<?php

namespace App\Services;

use App\Models\FeaturedUser;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Image;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class AddressService
{
    use ServiceTrait ;

    public function getAll(Array $relation = [], int $perPage = Null)
    {

        $params = [];

        if (!empty($relation)) $params['with_relations'] = 'true';
        if (!is_null($perPage)) $params['per_page'] = $perPage;


        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/address/users/get', $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            return collect($data);
        }

        abort(500, 'Erreur lors de la récupération des ménages.');
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


    public function getByUser($id,Array $relations=[])
    {
        $params = [];
        // if (!empty($relation)) $params['with_relations'] = implode(',', $relation);
        if (!empty($relation)) $params['with_relations'] = 'true';

        $cached_data = Cache::get("post_{$id}") ;
        if(!is_null($cached_data)){
            return $cached_data;
        }

        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/address/users/get/'.$id, $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            Cache::put("post_{$id}", $data, now()->addMinutes(5));
            return $data;
        }

        // Gérer les erreurs ici
        abort(404, 'Erreur lors de la récupération du menage.');


    }


}
