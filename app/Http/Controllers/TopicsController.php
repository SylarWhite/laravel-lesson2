<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic,User $user, Link $link)
	{
		$topics = Topic::query()->whereNotIn('category_id',[4])->withOrder($request->order)->paginate(8);
		$active_users = $user->getActiveUsers();
		$links = $link->getAllCached();
		return view('topics.index', compact('topics','active_users','links'));
	}

    public function show(Request $request,Topic $topic)
    {
        if(! empty($topic->slug) && $topic->slug != $request->slug){
            return redirect($topic->link(),301);
        }
        $showPremium = false;
        if($topic->price == 0 || $topic->user_id == \Auth::id() || $topic->buyers()->where('id',\Auth::id())->exists()){
            $showPremium = true;
        }

        return view('topics.show', compact('topic','showPremium'));
    }

    public function premium(Topic $topic)
    {
        if($topic->premiumTopic()){
            return redirect()->to($topic->link());
        }
        return redirect()->back();
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
	    $topic->fill($request->all());
	    $topic->user_id = Auth::id();
	    $topic->save();
	    return redirect()->to($topic->link())->with('success', '帖子创建成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploadHandler)
    {
        $data = [
            'success'   =>  false,
            'msg'       =>  '上传失败!',
            'file_path' =>  ''
        ];
        if($file = $request->upload_file){
            $result = $uploadHandler->save($request->upload_file,'topics',\Auth::id(),1024);
            if($result){
                $data['file_path']      =   $result['path'];
                $data['msg']            =   '上传成功';
                $data['success']        =   true;
            }
        }
        return $data;
	}
}
