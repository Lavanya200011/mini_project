
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Attendance System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold flex items-center space-x-2">
      📘 <span>Kcem Attendance System</span>
    </h1>
    <nav class="space-x-6">
      <a href="index.php" class="text-blue-600 font-semibold">Dashboard</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="max-w-4xl mx-auto bg-white mt-10 p-6 rounded shadow">
    <div class="border-b pb-4 mb-4 flex space-x-10">
      <button id="first" class="text-blue-600 font-medium border-b-2 hover:border-blue-600">Record Attendance</button>
      <button id="second" class="text-blue-600 font-medium border-b-2 hover:border-blue-600">View Records</button>
    </div>

    <h2 class="text-xl font-semibold mb-6">Record Student Attendance</h2>

    <form id="takeatten">
      <!-- Class & Date -->
      <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div>
          <label class="block text-sm font-medium mb-1">Class/Section</label>
          <select class="w-full border rounded px-3 py-2">
            <option>Class 1-A</option>
            <option>Class 1-B</option>
            <option>Class 2-A</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Date</label>
          <input type="date" class="w-full border rounded px-3 py-2" value="2025-04-22"/>
        </div>
      </div>

      <!-- Search -->
      <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Find Student</label>
        <input type="text" placeholder="Search by name or PRN NO" class="w-full border rounded px-3 py-2"/>
      </div>

      <!-- Student Attendance Table -->
      <div class="overflow-x-auto">
        <table class="w-full table-auto border-t">
          <thead>
            <tr class="bg-gray-100 text-left">
              <th class="px-4 py-2">Student</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Notes</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1 -->
            <tr class="border-t">
              <td class="px-4 py-3">
                <div>
                  <div class="font-medium">lavanya</div>
                  <div class="text-sm text-gray-500">24046791242519</div>
                </div>
              </td>
              <td class="px-4 py-3">
                <label class="mr-4"><input type="radio" name="status1"> Present</label>
                <label class="mr-4"><input type="radio" name="status1"> Absent</label>              </td>
              <td class="px-4 py-3">
                <textarea class="w-full border rounded px-2 py-1 text-sm" placeholder="Optional notes"></textarea>
              </td>
            </tr>

            <!-- Row 2 -->
            <tr class="border-t">
              <td class="px-4 py-3">
                <div>
                  <div class="font-medium">Emma Wilson</div>
                  <div class="text-sm text-gray-500">ST12346</div>
                </div>
              </td>
              <td class="px-4 py-3">
                <label class="mr-4"><input type="radio" name="status2"> Present</label>
                <label class="mr-4"><input type="radio" name="status2"> Absent</label>              </td>
              <td class="px-4 py-3">
                <textarea class="w-full border rounded px-2 py-1 text-sm" placeholder="Optional notes"></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Buttons -->
      <div class="mt-6 flex justify-end space-x-4">
        <button type="reset" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Reset</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Attendance</button>
      </div>
    </form>



   

        <div  id="viewatten" class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
          <h2 class="text-2xl font-semibold mb-6">📊 Attendance Records</h2>
      
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <select id="filter-class" class="p-2 border rounded">
              <option value="">All Classes</option>
              <option value="1-A">Class 1-A</option>
            </select>
            <input type="date" id="filter-from" class="p-2 border rounded" />
            <input type="date" id="filter-to" class="p-2 border rounded" />
            <select id="filter-status" class="p-2 border rounded">
              <option value="">All Statuses</option>
              <option value="Present">Present</option>
              <option value="Absent">Absent</option>
              <option value="Late">Late</option>
            </select>
          </div>
      
          <div class="mb-4">
            <input type="text" id="filter-search" placeholder="Search by name or PRN NO" class="w-full p-2 border rounded" />
          </div>
      
          <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse text-sm">
              <thead>
                <tr class="bg-gray-200 text-left">
                  <th class="p-2">Date</th>
                  <th class="p-2">Class</th>
                  <th class="p-2">Student</th>
                  <th class="p-2">Status</th>
                  <th class="p-2">Notes</th>
                  <th class="p-2">Actions</th>
                </tr>
              </thead>
              <tbody id="records-table" class="bg-white divide-y">
                <!-- Rows will be injected here -->
              </tbody>
            </table>
          </div>
        </div>
      
        <script>
          const loadRecords = () => {
            const params = new URLSearchParams({
              class: document.getElementById('filter-class').value,
              from: document.getElementById('filter-from').value,
              to: document.getElementById('filter-to').value,
              status: document.getElementById('filter-status').value,
              search: document.getElementById('filter-search').value,
            });
      
            fetch(`get_records.php?${params}`)
              .then(res => res.json())
              .then(data => {
                const tbody = document.getElementById('records-table');
                tbody.innerHTML = '';
      
                data.forEach(row => {
                  const statusColor = {
                    'Present': 'bg-green-100 text-green-700',
                    'Absent': 'bg-red-100 text-red-700',
                    'Late': 'bg-yellow-100 text-yellow-700'
                  }[row.status] || 'bg-gray-100';
      
                  tbody.innerHTML += `
                    <tr>
                      <td class="p-2">${new Date(row.date).toLocaleDateString()}</td>
                      <td class="p-2">Class 1-A</td>
                      <td class="p-2 font-medium">${row.name}<br><span class="text-sm text-gray-500">${row.student_id}</span></td>
                      <td class="p-2"><span class="px-2 py-1 text-sm rounded ${statusColor}">${row.status}</span></td>
                      <td class="p-2">${row.notes || ''}</td>
                      <td class="p-2 text-blue-600 underline cursor-pointer">Edit</td>
                    </tr>
                  `;
                });
              });
          };
      
          // Filter change listeners
          ['filter-class', 'filter-from', 'filter-to', 'filter-status', 'filter-search'].forEach(id => {
            document.getElementById(id).addEventListener('input', loadRecords);
          });
      
          window.onload = loadRecords;
        </script>
      




  </main>

  
    <script>
  // Get button and content elements
  const btnTake = document.getElementById('first');
  const btnView = document.getElementById('second');
  const sectionTake = document.getElementById('takeatten');
  const sectionView = document.getElementById('viewatten');

  // Show takeatten section
  btnTake.addEventListener('click', () => {
    sectionTake.style.display = 'block';
    sectionView.style.display = 'none';

    // Optional: change button styles
    btnTake.classList.add('bg-blue-500', 'text-white');
    btnView.classList.remove('bg-blue-500', 'text-white');
  });

  // Show viewatten section
  btnView.addEventListener('click', () => {
    sectionTake.style.display = 'none';
    sectionView.style.display = 'block';

    btnView.classList.add('bg-blue-500', 'text-white');
    btnTake.classList.remove('bg-blue-500', 'text-white');
  });

  // Optional: show takeatten by default
  window.addEventListener('DOMContentLoaded', () => {
    sectionTake.style.display = 'block';
    sectionView.style.display = 'none';
  });
</script>
</body>
</html>
