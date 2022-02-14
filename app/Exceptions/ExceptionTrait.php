<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait  ExceptionTrait{

    protected function apiException($request,$e){
        if($this->isModel($e)){
            return $this->modelResponse();
        }
        if($this->isHttp($e)){
            return $this->HttpResponse();
        }
        return parent::render($request, $e);
    }

    protected function isModel($e){
        return $e instanceof ModelNotFoundException;
    }
    protected function isHttp($e){
        return $e instanceof NotFoundHttpException;
    }

    protected function modelResponse(){
       return response()->json([
            'error' => "Model not found"
        ],Response::HTTP_NOT_FOUND);
    }

    protected function HttpResponse(){
        return response()->json([
            'error' => "Incorrect Route"
        ],Response::HTTP_NOT_FOUND);
    }
}
