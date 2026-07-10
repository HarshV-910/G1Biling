class GridDatatable {
    init() { this.GridjsTableInit() }
    GridjsTableInit() {
        document.getElementById("table-gridjs") && new gridjs.Grid({
            columns: [{
                name: "ID",
                formatter: function (e) { return gridjs.html('<span class="fw-semibold">' + e + "</span>") }
            },
                "Party ID", "Name", "GST No", "Mobile Number", "Address", "Pending Amount", "Total Amount", {
                name: "Actions", width: "120px",
                formatter: (_, owner) => {
                    const id = owner.cells[0].data;
                    return gridjs.html(
                        `<a href="party_form.php?p_id=${id}" class="text-reset mx-md-2"> 
                            <iconify-icon icon="mingcute:pencil-line"></iconify-icon> 
                        </a> &nbsp 

                        <a href="delete.php?p_id=${id}" class="text-reset"> 
                            <iconify-icon icon="mingcute:delete-line"></iconify-icon> 
                        </a>`
                    )
                },
            }],
            server: {
                url: 'data/party_data.php',
                then: data => data.party.map(party => [party.p_id, party.party_id, party.p_name, party.gst, party.mobile_no, party.p_address, party.pending_amount, 
                    party.total_amount])
            },
            pagination: { limit: 10 }, search: !0, sort: !0
        }).render(document.getElementById("table-gridjs")),










            document.getElementById("table-orderjs") && new gridjs.Grid({
                columns: [{
                    name: "ID",
                    formatter: function (e) { return gridjs.html('<span class="fw-semibold">' + e + "</span>") }
                },
                    "Date", "Party Name", "Card No.", "Design No", "Details", "Febrics", "Matching No.", "Cut", "Total Metre", "Rate", 
                    "Total Amount ", "Order Status", {name: "Actions", width: "120px",
                    formatter: (_, owner) => {
                        const id = owner.cells[0].data;
                        return gridjs.html(
                            `<a href="order_print.php?i_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:print-line"></iconify-icon> 
                            </a>

                            <a href="order_form.php?i_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:pencil-line"></iconify-icon> 
                            </a>

                            <a href="delete.php?i_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:delete-line"></iconify-icon>
                            </a>`
                        )
                    },
                }
            ],

                server: {
                    url: 'data/order_data.php',
                    then: data => data.invoice.map(invoice => [invoice.i_id, invoice.date, invoice.p_name, invoice.card_no, invoice.design_no, 
                        invoice.details, invoice.fabric, invoice.matching_no, invoice.cut, invoice.total_metre, invoice.rate, invoice.amount, 
                        invoice.status])
                },
                pagination: { limit: 10 }, search: !0, sort: !0
            }).render(document.getElementById("table-orderjs")),









            
            document.getElementById("table-chalanjs") && new gridjs.Grid({
                columns: [{
                    name: "ID",
                    formatter: function (e) { return gridjs.html('<span class="fw-semibold">' + e + "</span>") }
                },
                    "Date", "Chalan No", "Party Name", "Order No.", "Design No", "Cut", "Total Metre", "Rate", "Amount", "Total Amount", {
                    name: "Actions", width: "120px",
                    formatter: (_, owner) => {
                        const id = owner.cells[0].data;
                        return gridjs.html(
                            `<a href="chalan_print.php?c_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:print-line"></iconify-icon> 
                            </a>

                            <a href="chalan_form.php?c_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:pencil-line"></iconify-icon> 
                            </a>

                            <a href="delete.php?c_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:delete-line"></iconify-icon> 
                            </a>`
                        )
                    },
                }
            ],

                server: {
                    url: 'data/chalan_data.php',
                    then: data => data.chalan.map(chalan => [chalan.c_id, 
                        chalan.c_date, chalan.chalan_no, chalan.p_name, chalan.order_no, chalan.design_no, chalan.cut, chalan.total_metre, 
                        chalan.rate, chalan.amount, chalan.total_amount])
                },
                pagination: { limit: 10 }, search: !0, sort: !0
            }).render(document.getElementById("table-chalanjs")),











               document.getElementById("table-billjs") && new gridjs.Grid({
                columns: [{
                    name: "ID",
                    formatter: function (e) { return gridjs.html('<span class="fw-semibold">' + e + "</span>") }
                },
                    "Bill Date", "Bill No.", "Party Name", "Chalan No.", "Amount", "Total Amount",  "Discount ₹", "CGST", "SGST", 
                    "Total GST", "Final Amount", "Paid Amount", "Pending Amount", {
                    name: "Actions", width: "120px",
                    formatter: (_, owner) => {
                        const id = owner.cells[0].data;
                        return gridjs.html(
                            `<a href="bill_print.php?b_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:print-line"></iconify-icon> 
                            </a>

                            <a href="bill_form.php?b_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:pencil-line"></iconify-icon> 
                            </a>

                            <a href="delete.php?b_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:delete-line"></iconify-icon> 
                            </a>`
                        )
                    },
                }
            ],

                server: {
                    url: 'data/bill_data.php',
                    then: data => data.bill.map(bill => [bill.b_id, bill.b_date, bill.bill_no, bill.p_name, bill.chalan_no, bill.c_amount, bill.c_total_amount, bill.d_amount, 
                        bill.cgst, bill.sgst, bill.total_gst, bill.total_amount, bill.paid_amount, bill.pending_amount])
                },
                pagination: { limit: 10 }, search: !0, sort: !0
            }).render(document.getElementById("table-billjs")),









            document.getElementById("table-usersjs") && new gridjs.Grid({
                columns: [{
                    name: "ID",
                    formatter: function (e) { return gridjs.html('<span class="fw-semibold">' + e + "</span>") }
                },
                    "Name", "Mobile Number", "Mobile Number", "Address", {
                    name: "Image",
                    formatter: (image) => gridjs.html(
                        image
                            ? `<img src="assets/img/${image}" alt="Owner photo" style="width: 56px; height: 56px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(255,255,255,.15);">`
                            : '<span class="text-muted">No image</span>'
                    )
                }, "User Name", "Password", {
                    name: "Actions", width: "120px",
                    formatter: (_, owner) => {
                        const id = owner.cells[0].data;
                        return gridjs.html(
                            `<a href="owner_form.php?o_id=${id}" class="text-reset mx-md-2"> 
                                <iconify-icon icon="mingcute:pencil-line"></iconify-icon> 
                            </a> &nbsp 

                            <a href="delete.php?o_id=${id}" class="text-reset"> 
                                <iconify-icon icon="mingcute:delete-line"></iconify-icon> 
                            </a>`
                        )
                    }
                }],

                server: {

                    url: 'data/owner_data.php',
                    then: data => data.owner.map(owner => [owner.owner_id, owner.name, owner.mobile_1, owner.mobile_2, owner.address, owner.img || '', 
                        owner.user_name, owner.pass])
                },
                pagination: { limit: 10 }, search: !0, sort: !0
            }).render(document.getElementById("table-usersjs"));

    }
}

document.addEventListener("DOMContentLoaded", function (e) { (new GridDatatable).init() });