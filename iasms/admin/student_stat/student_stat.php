<?php
include '../../database_connection/database_connection.php';

$regions = array("Rift Valley", "Central", "Eastern", "Western", "Nyanza", "Nairobi", "Coast", "North Eastern", "Northern", "Abroad");
$regions_2 = array("-- Select Resident Region --", "Rift Valley", "Central", "Eastern", "Western", "Nyanza", "Nairobi", "Coast", "North Eastern", "Northern", "Abroad");
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIASMS</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="student_stat.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
  /* Optional: Add some custom styling for the chart container */
  #chart-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  </style>
</head>

<body>

  <div id="top-navigation">
    <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span><span
        style="font-family:serif"><?php echo "Admin"?></span></div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="../view_registered_students/view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="../../add_position.php">
        <li class="menu_items_list">Add Attachment Positions</li>
      </a>
      <a class="menu_items_link" href="../students_assumptions/students_assumptions.php">
        <li class="menu_items_list">Student Assumptions</li>
      </a>
      <a class="menu_items_link" href="student_stat.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Student Statistics</li>
      </a>
      <a class="menu_items_link" href="../../add_supervisor.php">
        <li class="menu_items_list">Add Supervisor</li>
      </a>
      <a class="menu_items_link" href="../visiting_score/visiting_supervisors_score.php">
        <li class="menu_items_list">Visiting Superviors Score</li>
      </a>
      <a class="menu_items_link" href="../company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
      </a>
      <a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <a class="menu_items_link" href="../change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../add_admin.php">
        <li class="menu_items_list">Add Admin</li>
      </a>
      <a class="menu_items_link" href="../../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <div class="container-fluid">
    <div id="main_content">
      <div class="panel">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle"> STUDENT STATISTICS</h2>
        </div>
        <div class="panel-body pbody">

          <div class="panel">
            <div class="panel-heading phead">
              <h2 class="panel-title ptitle"> Students Statistics</h2>
            </div>
            <div class="panel-body pbody">

              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="text-align:center">Rift Valley</th>
                    <th style="text-align:center">Central</th>
                    <th style="text-align:center">Eastern</th>
                    <th style="text-align:center">Western</th>
                    <th style="text-align:center">Nyanza</th>
                    <th style="text-align:center">Nairobi</th>
                    <th style="text-align:center">Coast</th>
                    <th style="text-align:center">North Eastern</th>
                    <th style="text-align:center">Northern</th>
                    <th style="text-align:center">Abroad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    echo "<tr style='text-align:center;font-size:1.1em' width='100%'>";
                    $mycounter = 0;
                    $region_counts = array();
                    while($mycounter < 10){ 
                      $selected_item = $regions[$mycounter];
                      $mysql_query_command_1 = "SELECT company_region FROM students_assumption WHERE company_region='$selected_item'";               
                      $execute_result_query = mysqli_query($conn, $mysql_query_command_1);
                      $row_cnt = mysqli_num_rows($execute_result_query); 
                      echo "<td>".$row_cnt."</td>";
                      $region_counts[] = $row_cnt;
                      $mycounter++;  
                    }
                    echo "</tr>";
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Chart Container -->
          <div id="chart-container">
            <canvas id="regionChart"></canvas>
          </div>

          <script>
          // Get the region data from PHP
          var regionCounts = <?php echo json_encode($region_counts); ?>;
          var regionLabels = <?php echo json_encode($regions); ?>;

          // Create the pie chart
          var ctx = document.getElementById('regionChart').getContext('2d');
          var regionChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: regionLabels,
              datasets: [{
                label: 'Students by Region',
                data: regionCounts,
                backgroundColor: [
                  '#4CAF50', // Green
                  '#2196F3', // Blue
                  '#FF9800', // Orange
                  '#9C27B0', // Purple
                  '#F44336', // Red
                  '#3F51B5', // Indigo
                  '#FFC107', // Amber
                  '#009688', // Teal
                  '#E91E63', // Pink
                  '#607D8B' // Blue Grey
                ],
                borderColor: [
                  '#388E3C',
                  '#1976D2',
                  '#F57C00',
                  '#7B1FA2',
                  '#D32F2F',
                  '#303F9F',
                  '#FFA000',
                  '#00796B',
                  '#C2185B',
                  '#455A64'
                ],
                borderWidth: 2,
                hoverOffset: 10 // Adds a slight pop-out effect on hover
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false, // Allows custom sizing
              plugins: {
                legend: {
                  position: 'right', // Move legend to the right for better layout
                  labels: {
                    font: {
                      size: 14,
                      family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                      weight: 'bold'
                    },
                    padding: 20,
                    usePointStyle: true, // Use circular markers
                    pointStyle: 'circle'
                  }
                },
                title: {
                  display: true,
                  text: 'Student Assumption by Region',
                  font: {
                    size: 20,
                    family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    weight: 'bold'
                  },
                  padding: {
                    top: 5,
                    bottom: 20
                  },
                  color: '#333'
                },
                tooltip: {
                  backgroundColor: 'rgba(0, 0, 0, 0.8)',
                  titleFont: {
                    size: 14,
                    weight: 'bold'
                  },
                  bodyFont: {
                    size: 12
                  },
                  padding: 10,
                  cornerRadius: 4,
                  callbacks: {
                    label: function(tooltipItem) {
                      var total = regionCounts.reduce((a, b) => a + b, 0);
                      var percentage = ((tooltipItem.raw / total) * 100).toFixed(1);
                      return `${tooltipItem.label}: ${tooltipItem.raw} students (${percentage}%)`;
                    }
                  }
                },
                datalabels: { // Add data labels plugin if needed (requires Chart.js datalabels plugin)
                  color: '#fff',
                  font: {
                    weight: 'bold',
                    size: 12
                  },
                  formatter: (value, context) => {
                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                    var percentage = ((value / total) * 100).toFixed(1);
                    return value > 0 ? `${percentage}%` : ''; // Show percentage only if value > 0
                  }
                }
              },
              animation: {
                animateScale: true, // Scale animation on load
                animateRotate: true // Rotate animation on load
              },
              layout: {
                padding: 20 // Add padding around the chart
              }
            }
          });
          </script>

        </div>
      </div>
    </div>
  </div>

</body>

</html>