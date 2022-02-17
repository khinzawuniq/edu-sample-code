<div class="card chat-box-wrapper d-none" id="chat_box_wrapper">
    <div class="card-body card-header-wrapper py-0 px-1" style="flex:none;">
        <div class="chat-close-wrapper py-1 float-right" style="margin-top: 5px;">
            <button type="button" class="close" id="close_chat_box" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <input type="text" name="search_chat_user" class="form-control messenger-search" id="search_chat_user" placeholder="Search" autocomplete="off">
    </div>

    <div class="card-body user-list p-1">
        
        <div class="messenger-favorites app-scroll-thin d-none"></div>

        {!! view('Chatify::layouts.listItem', ['get' => 'saved','chartid' => $chartid])->render() !!}

        {{-- Contact --}}
        <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);"></div>

        <div class="messenger-tab app-scroll" data-view="search">
            {{-- items --}}
            <p class="messenger-title">Search</p>
            <div class="search-records">
                <p class="message-hint"><span>Type to search..</span></p>
            </div>
        </div>

    </div>
</div>