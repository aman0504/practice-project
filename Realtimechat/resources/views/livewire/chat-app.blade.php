<div>

    <section style="background-color: #eee;">
        <div class="container py-5">

            <div class="row">

                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                    <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>

                    <div class="card">
                        <div class="card-body">

                            <ul class="list-unstyled mb-0">
                                @foreach ($users as $user)
                                    <li class="p-2 border-bottom" style="background-color: #eee;">
                                        <a href="javascript:void(0)" class="d-flex justify-content-between"
                                            wire:click="getId({{ $user->id }})">
                                            <div class="d-flex flex-row">
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                                    alt="avatar"
                                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                    width="60">
                                                <div class="pt-1">
                                                    <p class="fw-bold mb-0">{{ $user->name }}</p>
                                                    {{-- <p class="small text-muted">Hello, Are you there?</p> --}}
                                                </div>
                                            </div>
                                            <div class="pt-1">
                                                <p class="small text-muted mb-1">Just now</p>
                                                <span class="badge bg-danger float-end">1</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                </div>

                <div class="col-md-6 col-lg-7 col-xl-8">

                    <ul class="list-unstyled">
                        @if ($selectedUserChats)
                            @foreach ($selectedUserChats as $selectedUserChat)
                                @if ($selectedUserChat->sender_id === Auth::user()->id)
                                <li class="d-flex justify-content-end mb-4">
                                    <div class="card w-70">
                                        <div class="card-header d-flex justify-content-between p-3">
                                            <p class="fw-bold mb-0">{{$selectedUserChat->sender->name}}</p>
                                            <p class="text-muted small mb-0 chat-time"><i class="far fa-clock"></i>  {{Illuminate\Support\Carbon::parse($selectedUserChat->created_at)->format('H:i:s')}}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">
                                                {{$selectedUserChat->message}}

                                            </p>
                                        </div>
                                    </div>
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp"
                                        alt="avatar"
                                        class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong"
                                        width="60">
                                </li>
                                @else


                                    <li class="d-flex justify-content-start mb-4">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"
                                            alt="avatar"
                                            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong"
                                            width="60">
                                        <div class="card w-70">
                                            <div class="card-header d-flex justify-content-between p-3">
                                                <p class="fw-bold mb-0">{{ $selectedUserChat->sender->name }}</p>
                                                <p class="text-muted small mb-0 chat-time"><i class="far fa-clock"></i>
                                                {{Illuminate\Support\Carbon::parse($selectedUserChat->created_at)->format('H:i:s')}}
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">
                                                    {{ $selectedUserChat->message }}

                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        <li class="bg-white mb-3">
                            <div class="form-outline">
                                <textarea class="form-control" id="textAreaExample2" rows="4" wire:model="message"></textarea>
                                <label class="form-label" for="textAreaExample2">Message</label>
                            </div>
                            <div class="form-outline">
                                <input type="file" id="imageUpload" wire:model="image">
                                <label class="form-label" for="imageUpload">Upload Image</label>
                            </div>
                        </li>
                        <button type="button" class="btn btn-info btn-rounded float-end"
                            wire:click="store()">Send</button>
                    </ul>

                </div>

            </div>

        </div>
    </section>




</div>
