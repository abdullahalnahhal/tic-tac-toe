@extends('layouts.main')
@section('content')
<div class="row" style="height: 100%;">
	<div class="col-xs-6 col-xs-offset-3 grid">
		<div class="row" id='y-0'>
			<div class="col-xs-3 spot x-0" x='0' y='0'>0-0</div>
			<div class="col-xs-3 spot middle-column x-1" x='1' y='0'>1-0</div>
			<div class="col-xs-3 spot x-2" x='2' y='0'>2-0</div>
		</div>
		<div class="row middle-row" id="y-1">
			<div class="col-xs-3 spot x-0" x='0' y='1'>0-1</div>
			<div class="col-xs-3 spot middle-column x-1" x='1' y='1'>1-1</div>
			<div class="col-xs-3 spot x-2" x='2' y='1'>2-1</div>
		</div>
		<div class="row" id="y-2">
			<div class="col-xs-3 spot x-0" x='0' y='2'>0-2</div>
			<div class="col-xs-3 spot middle-column x-1" x='1' y='2'>1-2</div>
			<div class="col-xs-3 spot x-2" x='2' y='2'>2-2</div>
		</div>
	</div>
	<div class="col-xs-3 bg-success log-board">
		<strong>></strong> <span class="text-danger"> Start New Game</span>
		<pre id="log">
			<br><strong>Token : </strong>{{$token}}
		</pre>
	</div>
</div>

@endsection
@push('js')
<script type="text/javascript">
	$(".spot").click(function(event) {
		if (!$(this).hasClass('assigned')) {
			data = {
				"position_x": $(this).attr('x'),
				"position_y": $(this).attr('y'),
			}
			log("<strong class='text-danger'>X :</strong> select spot "+$(this).attr('x')+"-"+$(this).attr('y'));
			$(this).addClass('assigned');
			$(this).addClass('spot-success');
			$(this).html(template.o);
			request.post(data);
		}
	});
	var Template = function()
	{
		this.alert = function (message){
			alert ="<div class='alert alert-danger alert-dismissible'>"+
				"<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>"+
				" %message%"+
				"</div>";
			return alert.replace(/%message%/g, message);
		}
		this.o = "<i class='fa fa-circle-o fa-5x'></i>";
		this.x = "<i class='fa fa-close fa-5x'></i>";
	}
	var Request = function()
	{
		this.post = function(data)
		{
			$.ajax({
				url: "{{url('api/play')}}",
				type: 'POST',
				headers: {"Authorization": 'Bearer '+"{{$token}}"},
				data: data,
			})
			.done(function(data) {
				switch(data.status) {
					case 'new':
						response.new(data.slot);
						break;
					case 'win':
						response.win();
						break;
					case 'loose':
						response.loose(data.slot);
						break;
					case 'game_over':
						response.gameOver();
						break;
				}
			});
		}
		
	}
	var Response = function()
	{
		this.new = function(data)
		{
			$("#y-"+data.y)
			.find('.x-'+data.x)
			.addClass('spot-danger')
			.addClass('assigned')
			.html(template.x);
			log("<strong class='text-danger'>X :</strong> select spot "+data.x+"-"+data.y);
		}
		this.win = function(data)
		{
			this.assignAll();
			log("<strong class='text-danger'>Game Over :</strong> You Win!\n<a href=''> Play Again...? </a> ");
		}
		this.loose = function(data)
		{
			$("#y-"+data.y)
			.find('.x-'+data.x)
			.addClass('spot-danger')
			.addClass('assigned')
			.html(template.x);
			this.assignAll();
			log("<strong class='text-danger'>Game Over :</strong> You Loose! \n<a href=''> Play Again...? </a>");
		}
		this.assignAll = function()
		{
			$(".spot").each(function(index, el) {
				if (!$(this).hasClass('assigned')) {
					$(this).addClass('spot-secondary assigned');
				}
			});
		}
		this.gameOver = function()
		{
			log("<strong class='text-danger'>Game Over :</strong> <a href=''>Try Again!</a>");
		}
	}
	var log = function(message)
	{
		$("#log").append("\n"+message);
	}
	template = new Template;
	request = new Request;
	response = new Response;
</script>
@endpush