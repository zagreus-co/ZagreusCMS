@foreach($comments as $comment)
    <div class="card @if (!$comment->published) bg-secondary @endif">
        <div class="card-header">
            @if ($comment->commentable_type == 'Modules\Blog\Entities\Post')
            <a href="{{ route('post', $comment->commentable->slug) }}" target='_blank'>
                {{ $comment->commentable->title }}
            </a>
            @elseif ($comment->commentable_type == 'Modules\Page\Entities\Page')
            <a href="{{ route('module.page.view', $comment->commentable->slug) }}" target='_blank'>
                {{ $comment->commentable->title }}
            </a>
            @else 
            <font>
                {{ $comment->commentable->title }}
            </font>
            @endif
            @if (!$comment->published) <span class="badge badge-warning">برسی نشده</span> @endif
            <div class='float-left'>
                {{ $comment->user->full_name ?? $comment->guest_name }}
                <small class='@if ($comment->published) text-muted @endif'>({{ jdate($comment->created_at)->ago() }})</small>
            </div>
        </div>
        <div class="card-body" >{!! str_replace("\n", "<br>", $comment->comment) !!}</div>
        @if ($comment->child()->count() > 0)
            <div class="card-footer">@include('comment::partials.card', ['comments'=> $comment->child])</div>
        @endif
        <div class="card-body">
            <hr>
            <button onclick='openAnswerModal(this, {{ $comment->id }},{id: {{$comment->commentable_id}}, type: {{json_encode($comment->commentable_type)}} })' class="btn btn-success btn-sm"><i class="fa fa-comment"></i> پاسخ</button>
            <a href="{{ route('module.comment.togglePublish', $comment->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-{{ !$comment->published? 'eye' : 'eye-slash' }}"></i> {{ $comment->published? 'مخفی سازی' : 'تایید و نمایش' }}</a>
            <button onclick="openEditModal(this, {{ $comment->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</button>
            
            <button onclick="fireDelete(this, '{{route("module.comment.destroy", $comment)}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> حذف</button>
        </div>
    </div>
@endforeach