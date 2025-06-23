<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

trait ServiceTrait
{
    /**
     * Scope a query to get some relation of the model.
     *
     * @param Builder $query
     * @param array relations
     * @return Builder
     */
    private function getRelation(Builder $query , Array $relations=[]) : Builder
    {
        foreach($relations as $relation){
            if (!is_string($relation)) {
                throw new InvalidArgumentException('All elements in relations must be strings.');
            }
        }
        return $query->with($relations);
    }


    /**
     * 
     */
    private function render($response) // : Builder
    {
        $result = [
            'success' => $response->successful(),
            'errors' => null,
            'data' => null,
        ];
       
        if ($response->successful()) {
              $result['data'] = $response->json()['data'] ?? null;
            // return collect($data);
        } elseif ( in_array( $response->status() , [422,500])) {
        
            $result['errors'] = $response->json()['errors'] ?? [$response->json()['message'] ?? 'Erreur inconnue'];
            // throw new \Exception('Erreur de validation : ' . json_encode($errors));
        } else {
            dd($response->json()) ;
            // Autres erreurs
            throw new \Exception('Erreur lors de la création : ' . $response->body());
        }

        return  $result; 
    }

}