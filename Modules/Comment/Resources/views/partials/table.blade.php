<div class="overflow-x-auto">
    <div class="min-w-screen bg-white flex justify-center font-sans overflow-hidden">
    
    <table class="min-w-max w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <td>{{__('Author')}}</td>
                <td>{{ __('Comment') }}</td>
                <td>{{__('Submitted on')}}</td>
                <td>[*]</td>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($comments as $comment)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    {{ $comment->user->full_name ?? $comment->guest_name }} <small class='text-muted'>({{ jdate($comment->created_at)->ago() }})</small>
                </td>
                <td class="py-3 px-6 text-left">
                    {!! str_replace("\n", "<br>", $comment->comment) !!}
                </td>
                <td class="py-3 px-6 text-center">
                    @if ($comment->commentable_type == 'Modules\Blog\Entities\Post')
                        <a href="{{ route('module.blog.posts.openBySlug', $comment->commentable->slug) }}" target='_blank'>
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
                <td class="py-3 px-6 text-center flex flex-nowrap">
                    <button onclick='openAnswerModal(this, {{ $comment->id }},{id: {{$comment->commentable_id}}, type: {{json_encode($comment->commentable_type)}} })' class="btn-success btn-sm"><i class="fa fa-comment"></i> </button>
                    <a href="{{ route('module.comment.togglePublish', $comment->id) }}" class="btn-warning btn-sm"><i class="fa fa-{{ !$comment->published? 'eye' : 'eye-slash' }}"></i></a>
                    <button onclick="openEditModal(this, {{ $comment->id }})" class="btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                    
                    <button onclick="fireDelete(this, '{{route("module.comment.destroy", $comment)}}')" class="btn-danger btn-sm"><i class="fa fa-trash"></i></button>    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>