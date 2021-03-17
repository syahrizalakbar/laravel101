<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fruits;
use Validator;

class ApiController extends Controller
{
    function addFruit(Request $req) {
        $name = $req->name;
        $color = $req->color;
        $harga = $req->harga;

        $fruit = new Fruits();
        $fruit->name = $name;
        $fruit->color = $color;
        $fruit->harga = (double)$harga;

        if ($fruit->save()) {
            $res['is_success'] = true;
            $res['message'] = "BErhasil menambahkan fruit";
            $res['data'] = $fruit;
        } else {
            $res['is_success'] = false;
            $res['message'] = "Gagal menambahkan fruit";
            $res['data'] = $fruit;
        }

        return response()->json($res);
    }

    function getFruits(Request $req) {
        $fruits = Fruits::all();

        if ($fruits->isNotEmpty()) {
            $res['is_success'] = true;
            $res['message'] = "BErhasil menamdapatkan fruits";
            $res['data'] = $fruits;
        } else {
            $res['is_success'] = false;
            $res['message'] = "Gagal mendapatkan fruits";
            $res['data'] = $fruits;
        }

        return response()->json($res);
    }

    function searchFruits(Request $req) {
        $keyword = $req->keyword;


        /// mengggunakan validator
        $validation = Validator::make($req->post(), [
            'keyword' => ['required', 'min:3', 'email'],
        ]);
        if ($validation->fails()) {
            $res['is_success'] = false;
            $res['message'] = "Field not completed";
            $res['error'] = $validation->errors();

            return response()->json($res);
        }

        // if ($keyword == null) {
        //     $res['is_success'] = false;
        //     $res['message'] = "Field not completed";
        //     return response()->json($res, 403);
        // }


        $fruits = Fruits::where('name', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('color', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('harga', 'LIKE', '%'.$keyword.'%')
                            ->get();

        if ($fruits->isNotEmpty()) {
            $res['is_success'] = true;
            $res['message'] = "BErhasil menamdapatkan fruits";
            $res['data'] = $fruits;
        } else {
            $res['is_success'] = false;
            $res['message'] = "Gagal mendapatkan fruits";
            $res['data'] = $fruits;
        }

        return response()->json($res);
    }

    function editFruit(Request $req) {
        $id = $req->id;
        $name = $req->name;
        $color = $req->color;
        $harga = $req->harga;

        $fruit = Fruits::find($id);

        if ($fruit != null) {
            $fruit->name = $name;
            $fruit->color = $color;
            $fruit->harga = (double)$harga;
    
            if ($fruit->update()) {
                $res['is_success'] = true;
                $res['message'] = "BErhasil edit fruit";
                $res['data'] = $fruit;
            } else {
                $res['is_success'] = false;
                $res['message'] = "Gagal edit fruit";
                $res['data'] = $fruit;
            }
    
            return response()->json($res);
        } else {
            $res['is_success'] = false;
            $res['message'] = "Gagal fruit ga ada";
            return response()->json($res);
        }
        
    }


    function deleteFruit(Request $req) {
        $id = $req->id;

        $fruit = Fruits::find($id);

        if ($fruit != null) {
            if ($fruit->delete()) {
                $res['is_success'] = true;
                $res['message'] = "BErhasil hapus fruit";
                $res['data'] = $fruit;
            } else {
                $res['is_success'] = false;
                $res['message'] = "Gagal hapus fruit";
                $res['data'] = $fruit;
            }
    
            return response()->json($res);
        } else {
            $res['is_success'] = false;
            $res['message'] = "Gagal fruit ga ada";
            return response()->json($res);
        }
        
    }
}
