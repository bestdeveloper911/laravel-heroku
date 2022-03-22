@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Campaign')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Campaign')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Campaign')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('admin.SN')}}</th>
                                    <th width="15%">{{__('admin.Campaign')}}</th>
                                    <th width="15%">{{__('admin.Start Time')}}</th>
                                    <th width="15%">{{__('admin.End Time')}}</th>
                                    <th width="10%">{{__('admin.Banner')}}</th>
                                    <th width="10%">{{__('admin.Offer')}}</th>
                                    <th width="5%">{{__('admin.Show Homepage')}}</th>
                                    <th width="10%">{{__('admin.Status')}}</th>
                                    <th width="20%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaigns as $index => $campaign)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $campaign->name }}</td>
                                        <td>{{ date('h:i:A, d M, Y', strtotime($campaign->start_date)) }}</td>
                                        <td>{{ date('h:i:A, d M, Y', strtotime($campaign->end_date)) }}</td>
                                        <td> <img src="{{ asset($campaign->image) }}" alt="" width="100px"></td>
                                        <td>{{ $campaign->offer }}%</td>
                                        <td>
                                            @if ($campaign->show_homepage == 1)
                                                <span class="badge badge-success">{{__('admin.Yes')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('admin.No')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($campaign->status == 1)
                                                <a href="javascript:;" onclick="changeProductCategoryStatus({{ $campaign->id }})">
                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                            @else
                                                <a href="javascript:;" onclick="changeProductCategoryStatus({{ $campaign->id }})">
                                                    <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                        <a href="{{ route('admin.campaign.edit',$campaign->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $campaign->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <a href="{{ route('admin.campaign-product',$campaign->id) }}" class="btn btn-primary btn-sm" ><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </td>

                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/campaign/") }}'+"/"+id)
    }
    function changeProductCategoryStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/campaign-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);

            }
        })
        }
</script>
@endsection
