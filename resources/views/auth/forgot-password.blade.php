@extends('welcome')
@section('content')
	<main class="d-flex w-100">
		@if(session('status'))
		<div class="toast-container position-fixed top-50 start-50 translate-middle p-3 border-0">
			<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header #bebcbc">
					<strong class="me-auto">Succès</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">
					{{ session('status') }}
				</div>
			</div>
		</div>
		@endif
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">{{__('message.forgot_password')}}</h1>
							<p class="lead">
								{{__('message.enter_your_email_to_reset_password')}}.
								{{__('message.we_will_send_you_a_link_to_reset_your_password')}}
								{{__('message.if_you_dont_receive_email_check_your_spam_folder')}}
								{{__('message.or_try_again_later')}}
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST" action="{{route('password.email')}}" >
									@csrf
                                        <div class="mb-3">
											<label class="form-label">{{__('message.email')}}</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="{{__('message.enter_your_mail')}}" />
											@if($errors->has('email'))
											<span class="text-danger text-small">
												{{ $errors->first('email') }}
											</span>
											@endif
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">{{__('message.send')}}</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection