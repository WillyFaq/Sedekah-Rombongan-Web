<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Laporan</x-pageheading>

    <x-card title="Laporan {{ $page_title }}">
        <x-slot name="action">
            <a href="#" id="btn_pdf" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top"
                title="Donwload Pdf" target="blank"><i class="fas fa-file-download"></i></a>
        </x-slot>
        <x-slot name="body">
            <form class="row" id="frm_filter">
                <div class="col form-group">
                    <label for="tgl_start">Tangga Mulai</label>
                    <input type="date" class="form-control tgl" id="tgl_start">
                </div>
                <div class="col form-group">
                    <label for="tgl_end">Tanggal Berakhir</label>
                    <input type="date" class="form-control tgl" id="tgl_end">
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="40%">Proyek Donasi</th>
                            <th>Tanggal</th>
                            <th>Donasi</th>
                            <th>Donatur</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>Rp. <span id="total_donation">0</span>
                            </th>
                            <th>
                                <span id="total_donatur">0</span> Orang
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-slot>
    </x-card>
    <script type="text/javascript">
        $(document).ready(() => {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const empty_data = `<tr><td colspan="5"><p class="text-center">Tidak ada data.</p></td>/tr>`
            const loading_data = `<tr><td colspan="5"><p class="text-center">Loading...</p></td>/tr>`
            $("#tbody").html(empty_data)

            $(".tgl").on("change", () => {
                const tgl_start = $("#tgl_start").val()
                const tgl_end = $("#tgl_end").val()
                console.log(tgl_start, tgl_end)
                if (tgl_start == "" || tgl_end == "") {
                    // error
                    return
                }
                const ts = Date.parse(tgl_start);
                const te = Date.parse(tgl_end);
                if (te < ts) {
                    // error
                    $("#tgl_start").addClass("is-invalid")
                    $("#tgl_end").addClass("is-invalid")
                    return
                }

                $("#tgl_start").removeClass("is-invalid")
                $("#tgl_end").removeClass("is-invalid")
                console.log(ts, te)
                // let formData = new FormData(document.getElementById("frm_filter"))
                let formData = new FormData()
                formData.append("tgl_start", tgl_start)
                formData.append("tgl_end", tgl_end)
                $("#tbody").html(loading_data)
                $.ajax({
                    type: 'GET',
                    url: "{{ url('report') }}" + `?tgl_start=${tgl_start}&tgl_end=${tgl_end}`,
                    // data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        const res = draw_table(response)
                        if (res == "") {
                            $("#tbody").html(empty_data)
                        } else {
                            $("#tbody").html(res)
                            $("#total_donation").html(response.total_donasi)
                            $("#total_donatur").html(response.total_donatur)
                            $("#btn_pdf").attr("href", "{{ url('report/pdf') }}" +
                                `?tgl_start=${tgl_start}&tgl_end=${tgl_end}`)
                        }
                    },
                    error: (response) => {
                        let error_msg = empty_data + ""
                        error_msg +=
                            `<tr><td colspan="5"><p class="text-center"><strong>${response.statusText}</strong> <br>${response.responseJSON.message}</p></td>/tr>`

                        $("#tbody").html(error_msg)
                    }
                });
            })
        })
        const draw_table = (response) => {
            if (response.data.length == 0) return ""
            let ret = ""
            response.data.map((item, i) => {
                ret += `
                <tr>
                    <td>${i+1}</td>  
                    <td>${item.judul}<br /><small>${item.lokasi}</small></td>  
                    <td>${item.tgl_mulai}</td>  
                    <td>Rp. ${item.donasi}</td>  
                    <td>${item.donatur} orang</td>  
                </tr>
                `
            })
            return ret
        }
    </script>
</x-layout>
