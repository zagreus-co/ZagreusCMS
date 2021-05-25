<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <td>فرستنده</td>
                    <td>متن نظر</td>
                    <td>ارسال شده در</td>
                    <td>[*]</td>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->full_name ?? $comment->guest_name }} <small class='text-muted'>({{ jdate($comment->created_at)->ago() }})</small></td>
                        <td>{!! str_replace("\n", "<br>", $comment->comment) !!}</td>
                        <td>
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
                        </td>
                        <td>
                            <button onclick='openAnswerModal(this, {{ $comment->id }},{id: {{$comment->commentable_id}}, type: {{json_encode($comment->commentable_type)}} })' class="btn btn-success btn-sm"><i class="fa fa-comment"></i> پاسخ</button>
                            <a href="{{ route('module.comment.togglePublish', $comment->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-{{ !$comment->published? 'eye' : 'eye-slash' }}"></i> {{ $comment->published? 'مخفی سازی' : 'تایید و نمایش' }}</a>
                            <button onclick="openEditModal(this, {{ $comment->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</button>
                            
                            <button onclick="fireDelete(this, '{{route("module.comment.destroy", $comment)}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> حذف</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>