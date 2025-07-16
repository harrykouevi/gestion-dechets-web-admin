<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


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

    /**
     * Attache un fichier Livewire à une requête HTTP Laravel.
     *
     * @param PendingRequest $http  Objet Laravel HTTP en cours
     * @param string         $field Nom du champ à envoyer
     * @param UploadedFile   $file  Fichier Livewire
     * @return PendingRequest       L'objet HTTP mis à jour
     * @throws \Exception
     */
    public function attachFileToHttp(PendingRequest $http, string $field, UploadedFile $file): PendingRequest
    {
        $originalName = $file->getClientOriginalName();
        $realPath = $file->getRealPath();

        if (!file_exists($realPath) || !is_readable($realPath)) {
            // Copier dans un fichier lisible temporaire
            // dd('ggg') ;
            $tempFilename = 'tmp_' . Str::uuid() . '_' . $originalName;
            $publicTempPath = storage_path('app/public/' . $tempFilename);
            
            copy($realPath, $publicTempPath);

            // Assure que le fichier sera supprimé plus tard (optionnel)
            register_shutdown_function(function () use ($publicTempPath) {
                if (file_exists($publicTempPath)) {
                    @unlink($publicTempPath);
                }
            });

            return $http->attach($field, fopen($publicTempPath, 'r'), $originalName);
        }

        // Fichier lisible, pas besoin de copie
        return $http->attach($field, fopen($realPath, 'r'), $originalName);
    }

}