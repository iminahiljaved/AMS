<?php $this->load->view('includes/header'); ?>
<style>
  #attendance_list tbody td a {
    font-weight: bold;
    font-size: 14px;
  }
</style>
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <!--**********************************
    Sidebar start
***********************************-->
    <?php $this->load->view('includes/sidebar'); ?>
    <!--**********************************
    Sidebar end
***********************************--> <!--**********************************
	Content body start
***********************************-->
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-xl-4 col-sm-12">
            <nav class="nav nav-pills flex-column flex-sm-row">
              <a class="flex-sm-fill fs-4 text-sm-center nav-link active" href="#navpills2-1" data-bs-toggle="tab" aria-expanded="false"><strong>AMS</strong></a>
              <a class="flex-sm-fill fs-4 text-sm-center nav-link ms-4" href="#navpills2-2" data-bs-toggle="tab" aria-expanded="false"><strong>PMS</strong></a>
            </nav>
          </div>
          <div class="col-xl-2 col-sm-12">
            <div class="card">
              <div class="card-body text-sm-center py-3 text-primary">
                <input style="border:none; height:20px;" name="datepicker" class="text-primary fs-6 fw-bold datepicker-default2 form-control p-0" value="<?= date('j F, Y') ?>" id="from">
              </div>
            </div>
          </div>
          <div class="tab-content">
            <div id="navpills2-1" class="tab-pane active">
              <div class="row">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row shapreter-row">
                        <?php
                        if ($this->ion_auth->is_admin() || permissions('attendance_view')) {
                        ?>
                          <?php
                          $totalStaff = $report["present"] + $report["leave"] + $report["abs"];
                          if ($totalStaff > 0) {
                            $perCentages = $report["present"] / $totalStaff * 100;
                            $perStaff = $perCentages . '%';
                          } else {
                            $perStaff = '0%';
                          }

                          ?>
                          <div class="col-xl-4 col-lg-4 col-sm-4 col-6">
                            <div class="static-icon mx-5">
                              <div class="d-flex">

                                <?php
                                if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
                                ?>
                                  <h4 class="text-primary">Staff</h4>
                                <?php
                                } else {
                                ?>
                                  <h4 class="text-primary">Working Days</h4>
                                <?php
                                } ?>
                                <h4 class="count ms-auto mb-0"><a class="text-primary" id="total_staff" href="javascript:void(0)"><?= $report["total_staff"] ?></a></h4>
                              </div>
                              <?php
                              if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
                              ?>
                                <p class="mb-0 text-muted" style="margin-top: -10px;">(Attendance)</p>
                              <?php
                              } else {
                              ?>
                                <p class="mb-0 text-muted" style="margin-top: -10px;">(This Month)</p>
                              <?php
                              }
                              ?>
                              <div class="progress default-progress mt-2">
                                <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= $perStaff ?>; height:8px;" role="progressbar">
                                  <span class="sr-only"><?= $perStaff ?> Complete</span>
                                </div>
                              </div>
                              <div class="mt-2">
                                <p class="mb-0">Present<strong class="float-end me-2"><a class="text-primary" id="total_present" href="javascript:void(0);"><?= $report["present"] ?></a></strong></p>
                                <p class="mb-0">On Leave<strong class="float-end me-2"><a id="total_leave" class="text-warning" href="javascript:void(0);"><?= $report["leave"] ?></a></strong></p>
                                <p class="mb-0">Absent<strong class="float-end me-2"><a class="text-danger " id="total_absent" href="javascript:void(0);"><?= $report["abs"] ?></a></strong></p>
                              </div>
                            </div>
                          </div>

                          <?php
                          $totalleave = $report["leave_approved"] + $report["leave_pending"] + $report["leave_rejected"];
                          if ($totalleave > 0) {
                            $perCentage = $report["leave_approved"] / $totalleave * 100;
                            $perLeave = $perCentage . '%';
                          } else {
                            $perLeave = '0%';
                          }

                          ?>
                          <div class="col-xl-4 col-lg-4 col-sm-4 col-6">
                            <div class="static-icon mx-5">
                              <div class="d-flex">
                                <h4 class="text-primary">Leaves</h4>
                                <h4 class="count text-primary ms-auto mb-0"><?= $totalleave ?></h4>
                              </div>
                              <p class="mb-0 text-muted" style="margin-top: -10px;">(This month)</p>
                              <div class="progress default-progress mt-2">
                                <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= $perLeave ?>; height:8px;" role="progressbar">
                                  <span class="sr-only"><?= $perLeave ?> Complete</span>
                                </div>

                              </div>
                              <div class="mt-2">
                                <p class="mb-0">Approved<strong class="float-end me-2"><a class="text-primary" href="javascript:void(0);"><?= $report["leave_approved"] ?></a></strong></p>
                                <p class="mb-0">Pending<strong class="float-end me-2"><a class="text-warning " href="javascript:void(0);"><?= $report["leave_pending"] ?></a></strong></p>
                                <p class="mb-0">Rejected<strong class="float-end me-2"><a class="text-danger " href="javascript:void(0);"><?= $report["leave_rejected"] ?></a></strong></p>
                              </div>
                            </div>
                          </div>
                          <?php
                          $totalBio = $report["bio_approved"] + $report["bio_pending"] + $report["bio_rejected"];
                          if ($totalBio > 0) {
                            $perCent = $report["bio_approved"] / $totalBio * 100;
                            $perBio = $perCent . '%';
                          } else {
                            $perBio = '0%';
                          }

                          ?>
                          <div class="col-xl-4 col-lg-4 col-sm-4 col-6">
                            <div class="static-icon mx-5">
                              <div class="d-flex">
                                <h4 class="text-primary">Biometrics</h4>
                                <h4 class="count text-primary ms-auto mb-0"><?= $totalBio ?></h4>
                              </div>
                              <p class="mb-0 text-muted" style="margin-top: -10px;">(This month)</p>
                              <div class="progress default-progress mt-2">
                                <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= $perBio ?>; height:8px;" role="progressbar">
                                  <span class="sr-only"><?= $perBio ?> Complete</span>
                                </div>
                              </div>
                              <div class="mt-2">
                                <p class="mb-0">Approved<strong class="text-primary float-end me-2"><?= $report["bio_approved"] ?></strong></p>
                                <p class="mb-0">Pending<strong class="text-warning float-end me-2"><?= $report["bio_pending"] ?></strong></p>
                                <p class="mb-0">Rejected<strong class="text-danger float-end me-2"><?= $report["bio_rejected"] ?></strong></p>
                              </div>
                            </div>
                          </div>
                        <?php
                        } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-9">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="text-primary">Attendance</h4>
                    </div>
                    <div class="card-body mb-5 px-4">
                      <div class="table-responsive">
                        <table id="attendance_list" class="table table-sm mb-0">
                          <thead>
                          </thead>
                          <tbody id="customers">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="card">
                    <div class="card-header mb-0">
                      <h4 class="text-primary">Upcoming Events</h4>
                    </div>
                    <div class="card-body p-0">
                      <?php
                      if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
                      ?>
                        <div id="DZ_W_Todo1" class="widget-media dlab-scroll p-4 height630 mb-0">
                        <?php
                      } else {
                        ?>
                          <div id="DZ_W_Todo1" class="widget-media dlab-scroll p-4 height400 mb-0">

                          <?php
                        } ?>
                          <ul class="timeline ">
                            <?php foreach ($events as $event) : ?>
                              <li>
                                <div class="timeline-panel">
                                  <div class="avatar avatar-xl me-2">
                                    <?php if ($event["profile"]) : ?>
                                      <?php
                                      if (file_exists('assets/uploads/profiles/' . $event["profile"])) {
                                        $file_upload_path = 'assets/uploads/profiles/' . $event["profile"];
                                      } else {
                                        $file_upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $event["profile"];
                                      }
                                      ?>
                                      <div class=""><img class="rounded-circle img-fluid" src="<?= base_url($file_upload_path) ?>" width="40" alt=""></div>
                                    <?php else : ?>
                                      <div class="d-flex align-items-center flex-wrap">
                                        <ul class="kanbanimg me-3">
                                          <li><span><?= $event["short"] ?></span></li>
                                        </ul>
                                      </div>
                                    <?php endif ?>

                                  </div>
                                  <div class="media-body ms-2">
                                    <h5 class="mb-1"><?= $event["user"] ?></h5>
                                    <small class="d-block"><?= $event["event"] . ' ' . $event["date"] ?></small>
                                  </div>
                                </div>
                              </li>
                            <?php endforeach ?>
                          </ul>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="navpills2-2" class="tab-pane">
                <h5>2nd</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--**********************************
	Content body end
***********************************-->
      <?php $this->load->view('includes/footer'); ?>
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script>
      $(document).ready(function() {
        setFilter();
        $(document).on('change', '#from', function() {
          var date = $('#from').val();
          var all = 0;
          var present = 0;
          var absent = 0;
          var leave = 0;
          setFilter(date, all, present, absent, leave);
        });
        $(document).on('click', '#total_present', function() {
          var date = $('#from').val();
          var all = 0;
          var present = 1;
          var absent = 0;
          var leave = 0;
          setFilter(date, all, present, absent, leave);
        });
        $(document).on('click', '#total_absent', function() {
          var date = $('#from').val();
          var all = 0;
          var present = 0;
          var absent = 1;
          var leave = 0;
          setFilter(date, all, present, absent, leave);
        });
        $(document).on('click', '#total_leave', function() {
          var date = $('#from').val();
          var all = 0;
          var present = 0;
          var absent = 0;
          var leave = 1;
          setFilter(date, all, present, absent, leave);
        });
        $(document).on('click', '#total_staff', function() {
          var date = $('#from').val();
          var all = 1;
          var present = 0;
          var absent = 0;
          var leave = 0;
          setFilter(date, all, present, absent, leave);
        });

        function setFilter(date, all, present, absent, leave) {
          callAjax(date, all, present, absent, leave);
        }

        function callAjax(date, all, present, absent, leave) {
          console.log(date, all, present, absent, leave);
          $.ajax({
            url: '<?= base_url('home/get_home_attendance') ?>',
            type: 'GET',
            data: {
              date: date,
              all: present,
              present: present,
              absent: absent,
              leave: leave,
            },
            success: function(response) {
              var tableData = JSON.parse(response);
              showTable(tableData.attendance);
              console.log(tableData);
              $("#total_present").html(tableData.counts.present);
              $("#total_leave").html(tableData.counts.leave);
              $("#total_absent").html(tableData.counts.abs);
              var total = tableData.counts.present + tableData.counts.leave + tableData.counts.abs;
              $("#total_staff").html(total);

            },
            complete: function() {},
            error: function(error) {
              console.error(error);
            }
          });
        }

        function showTable(data) {
          var table = $('#attendance_list');
          if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
          }
          emptyDataTable(table);
          var thead = table.find('thead');
          var uniqueDates = getUniqueDates(data);
          var theadRow = '<tr>';
          theadRow += '<th>Employee ID</th>';
          theadRow += '<th>Name</th>';
          theadRow += '<th>Attendance</th>';
          theadRow += '</tr>';
          thead.html(theadRow);
          var tbody = table.find('tbody');
          data.forEach(user => {
            var userRow = '<tr>';
            userRow += '<td>' + user.user + '</td>';
            userRow += '<td>' + user.name + '</td>';

            uniqueDates.forEach(date => {
              if (user.dates[date]) {
                userRow += '<td>' + user.dates[date].join('<br>') + '</td>';
              } else {
                userRow += '<td>Absent</td>';
              }
            });

            userRow += '</tr>';
            tbody.append(userRow);
          });

          table.DataTable({
            "paging": true,
            "searching": false,
            "language": {
              "paginate": {
                "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
              }
            },
            "info": false,
            "dom": '<"top"i>rt<"bottom"lp><"clear">',
            "lengthMenu": [7, 14],
            "pageLength": 7
          });
        }

        function emptyDataTable(table) {
          table.find('thead').empty();
          table.find('tbody').empty();
        }
      });

      function getUniqueDates(data) {
        // Extract unique dates from the data
        var uniqueDates = [];
        data.forEach(user => {
          Object.keys(user.dates).forEach(date => {
            if (!uniqueDates.includes(date)) {
              uniqueDates.push(date);
            }
          });
        });

        // Sort the dates in ascending order
        uniqueDates.sort();

        return uniqueDates;
      }
      $(document).ready(function() {
        $(".dataTables_info").appendTo("#attendance_list_wrapper .bottom");
        $(".dataTables_length").appendTo("#attendance_list_wrapper .bottom");
      });
      $('.datepicker-default2').daterangepicker({
        locale: {
          format: date_format_js
        },
        singleDatePicker: true,
        maxDate: moment()
      });
    </script>
</body>

</html>