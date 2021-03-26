<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index(){
        $posts = Post::latest()->get();
        return response([
            'success'=>true,
            'message'=>'List Semua Post',
            'data'=>$posts,
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ],
            [
                'title.required' => 'Masukkan Title Post !',
                'content.required' => 'Masukkan Content Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $post = Post::create([
                'title'     => $request->input('title'),
                'content'   => $request->input('content')
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
        }
    }
    //ini adalah method show berdasarkan id
    public function show($id){
        $post=Post::whereId($id)->first();
        if($post){
            return response()->json([
                'success'=>true,
                'message'=>'Detail Post!',
                'data'=>$post,
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Post tidak ditemukan',
                'data'=>'',
            ],401);
        }
    }
    //ini adalah method untuk update data
    public function update(Request $request){
        //validate data 
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required',
        ],[
            'title.required'=>'Masukan Title Post!',
            'content.required'=>'Masukan Content Post', 
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan isi bidang yang kosong',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $post = Post::whereId($request->input('id'))->update([
                'title'=>$request->input('title'),
                'content'=>$request->input('content'),
            ]);

            if($post){
                return response()->json([
                    'success'=>true,
                    'message'=>'Post Berhasil di Update!',
                ], 200);
            } else {
             return response()->json([
                 'success'=>false,
                 'message'=>'Post Gagal di Update',
             ], 401);   
            }
        }
    }

    //ini adlaah method delete
    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        if($post){
            return response()->json([
                'success'=>true,
                'message'=>'Post Berhasil dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success'=> false,
                'message'=>'Post Gagal Dihapus!',
            ], 400);
        }
    }
}
