{{-- -------------------- Saved Messages -------------------- --}}
@if($get == 'saved')
    <table class="d-none messenger-list-item m-li-divider @if('user_'.Auth::user()->id == $chartid && $chartid != "0") m-list-active @endif">
        <tr data-action="0">
            
            <td>
            <div class="avatar av-m" style="background-color: #d9efff; text-align: center;">
                <span class="far fa-bookmark" style="font-size: 22px; color: #68a5ff; margin-top: calc(50% - 10px);"></span>
            </div>
            </td>
            
            <td>
                <p data-id="{{ 'user_'.Auth::user()->id }}">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- All users/group list -------------------- --}}
@if($get == 'users')
<table class="messenger-list-item @if($user->id == $id && $id != "0") m-list-active @endif" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td style="position: relative">
            @if($user->active_status)
                <span class="activeStatus"></span>
            @endif
        <div class="avatar av-m" 
        style="background-image: url('{{ asset('/uploads/'.$user->photo) }}');">
        </div>
        </td>
        {{-- center side --}}
        <td>
        <p data-id="{{ $type.'_'.$user->id }}">
            {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }} 
            <span>{{ $lastMessage->created_at->diffForHumans() }}</span></p>
        <span>
            {{-- Last Message user indicator --}}
            {!!
                $lastMessage->from_id == Auth::user()->id 
                ? '<span class="lastMessageIndicator">You :</span>'
                : ''
            !!}
            {{-- Last message body --}}
            @if($lastMessage->attachment == null)
            {{
                strlen($lastMessage->body) > 30 
                ? trim(substr($lastMessage->body, 0, 30)).'..'
                : $lastMessage->body
            }}
            @else
            <span class="fas fa-file"></span> Attachment
            @endif
        </span>
        {{-- New messages counter --}}
            {!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}
        </td>
        
    </tr>
</table>
@endif

@if($get == 'group')
<table class="messenger-list-item @if($group->ref_no == $id && $id != "0") m-list-active @endif" data-contact="{{ $group->ref_no }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td style="position: relative">
            @if($group->active_status)
                <span class="activeStatus"></span>
            @endif
        <div class="avatar av-m" 
        style="background-image: url('{{ asset('/assets/images/group.png') }}');">
        </div>
        
        </td>
        {{-- center side --}}
        <td>
        <p data-id="{{ $type.'_'.$group->ref_no }}">
            {{ strlen($group->name) > 12 ? trim(substr($group->name,0,12)).'..' : $group->name }} 
            <span>{{ !empty($lastMessage)?$lastMessage->created_at->diffForHumans():'-' }}</span></p>
        @if(!empty($lastMessage))
        <span>
            {{-- Last Message user indicator --}}
            {!!
                $lastMessage->from_id == Auth::user()->id 
                ? '<span class="lastMessageIndicator">You :</span>'
                : ''
            !!}
            {{-- Last message body --}}
            @if($lastMessage->attachment == null)
            {{
                strlen($lastMessage->body) > 30 
                ? trim(substr($lastMessage->body, 0, 30)).'..'
                : $lastMessage->body
            }}
            @else
            <span class="fas fa-file"></span> Attachment
            @endif
        </span>
        @endif
        {{-- New messages counter --}}
            {!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}
        </td>
        
    </tr>
</table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
@if(isset($user))
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td>
            <div class="avatar av-m"
            style="background-image: url('{{ asset('/uploads/'.$user->photo) }}');">
            </div>
        </td>
        {{-- center side --}}
        <td>
            <p data-id="{{ $type.'_'.$user->id }}">
                {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }} </p>
        </td>
    </tr>
</table>
@endif
@endif
{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
<div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif