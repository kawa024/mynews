<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\Profile_History;

use Carbon\Carbon;

class ProfileController extends Controller
 {
    //
    public function add()
    {
        \Debugbar::info('test');
        return view('admin.profile.create');    
    }
    
    public function create(Request $request)
    {
        
        $this->validate($request, Profile::$rules);
        
        $profiles = new Profile;
        $form = $request->all();
        
       
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      
      // データベースに保存する
      $profiles->fill($form);
      $profiles->save();
        
        return redirect('admin/profile/create');
    }
    
    public function edit(Request $request)
    {
      // Profile Modelからデータを取得する
      $profiles = Profile::find($request->id);
      if (empty($profiles)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profiles_form' => $profiles]);
    }
    
    public function update(Request $request)
   {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // News Modelからデータを取得する
      $profiles = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profiles_form = $request->all();
      unset($profiles_form['_token']);

      // 該当するデータを上書きして保存する
      $profiles->fill($profiles_form)->save();
      
      $profile_history = new Profile_History;
      $profile_history->profile_id = $profiles->id;
      $profile_history->edited_at = Carbon::now();
      $profile_history->save();

      return redirect('admin/profile');
    }
    
    public function index(Request $request)
    {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function delete(Request $request)
    {
      // 該当するNews Modelを取得
      $profiles = Profile::find($request->id);
      // 削除する
      $profiles->delete();
      return redirect('admin/profile/');
    }  
    
    
  }
