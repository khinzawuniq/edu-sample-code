@extends('layouts.app')

@section('content')
<div class="container unpaid-list py-4">

    <div class="row mb-3">
        <div class="col-6">
            <button class="btn btn-success" id="move_paid">Move to Paid Lists</button>
        </div>
        <div class="col-6 text-right">
            <a href="{{url('/courses/certificate-payment/'.$certificate_id.'?course_id='.$data['course_id'].'&module_id='.$data['module_id'])}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped unpaid-list-tbl">
                <thead>
                    <tr class="bg-primary text-white">
                        <th width="80px"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                        <th>Students</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($students) > 0)
                    @foreach($students as $student)
                    <tr class="row-{{$student->id}}">
                        <td><input type="checkbox" name="student_id[]" class="eachData" data-id="{{$student->id}}"></td>
                        <td> {{$student->user->name}} </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2" align="center">Empty Unpaid List!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .payment-list-tbl th, .payment-list-tbl td {
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {

        $('#example-select-all').on('click', function(e) {
			if($(this).is(':checked',true))  
			{
				$(".eachData").prop('checked', true);  
			} else {  
				$(".eachData").prop('checked',false);  
			}  
        });

        $("#move_paid").click(function() {
            var allVals = [];
			$(".eachData:checked").each(function() {  
				allVals.push($(this).attr('data-id'));
			});  


			if(allVals.length <=0)  
			{  
				alert("Please select row.");  
			}  else {  

				var check = confirm("Are you sure you want to paid this row?");  
				if(check == true){  

					var join_selected_values = allVals.join(","); 

					$.ajax({
						url: "{{url('/courses/do-paid-students/'.$data['course_id'])}}",
						type: 'get',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: 'ids='+join_selected_values,
						success: function (response) {
							if(response == 200) {
								allVals.forEach(function(item, index) {
                                    $(".row-"+item).remove();
                                });
							}else {
								alert("Your are unauthorized for paid action!");
							}
						},
						error: function (response) {
							alert(response.responseText);
						}
					});
				}  
			}
        });

        // // Handle click on "Select all" control
        // $('#example-select-all').on('click', function(){
        //     // Get all rows with search applied
        //     var rows = datatable.rows({ 'search': 'applied' }).nodes();
        //     // Check/uncheck checkboxes for all rows in the table
        //     $('input[type="checkbox"]', rows).prop('checked', this.checked);
        // });

        // // Handle click on checkbox to set state of "Select all" control
        // $('.paid-list-tbl tbody').on('change', 'input[type="checkbox"]', function(){
        //     // If checkbox is not checked
        //     if(!this.checked){
        //         var el = $('#example-select-all').get(0);
        //         // If "Select all" control is checked and has 'indeterminate' property
        //         if(el && el.checked && ('indeterminate' in el)){
        //             // Set visual state of "Select all" control
        //             // as 'indeterminate'
        //             el.indeterminate = true;
        //         }
        //     }
        // });

        // $('.eachData').on('click', function() {
                    
        // });
    });
    
</script>
@endpush