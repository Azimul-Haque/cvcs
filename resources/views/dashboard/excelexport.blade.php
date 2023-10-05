<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Export</title>
	{!!Html::script('js/table2excel.js')!!}
	<script>
	  function table2excel() {
	  	var table2excel = new Table2Excel();
	    table2excel.export(document.querySelectorAll("table"));
	  }
	</script>
</head>
<body>
	<button onclick="table2excel()">Download Excel</button>
	<table>
		<thead>
			<tr>
				<th>Sl.</th>
				<th>Member ID</th>
				<th>Name</th>
				<th>Name Bangla</th>
				<th>NID</th>
				<th>DoB</th>
				<th>Mobile Number</th>
				<th>Email</th>
				<th>Joining Date</th>
				<th>Designation</th>
				<th>QR Code</th>
			</tr>
		</thead>
		<tbody>
			@php
				$sl = 1;
			@endphp
			@foreach($users as $user)
				<tr>
					<td>{{ $sl }}</td>
					<td>{{ $user->member_id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->name_bangla }}</td>
					<td>{{ $user->nid }}</td>
					<td>{{ date('F d, Y', strtotime($user->dob)) }}</td>
					<td>{{ $user->mobile }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ date('F d, Y', strtotime($user->joining_date)) }}</td>
					<td>{{ $user->position ? $user->position->name : '' }}</td>
					{{-- <td>{!! QrCode::size(200)->format('eps')->generate('ItSolutionStuff.com', public_path('images/qrcode.eps')); !!}</td> --}}
				</tr>
				@php
					$sl++;
				@endphp
			@endforeach
		</tbody>
	</table>
</body>
</html>