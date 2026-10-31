const form = document.getElementById('ajaxForm');
const records = document.getElementById('records');
const statusBox = document.getElementById('status');
let students = [];
function cell(row, value) { const td=document.createElement('td'); td.textContent=value; row.appendChild(td); }
async function loadStudents() {
    try {
        const response=await fetch('backend/api_students.php'); students=await response.json();
        records.replaceChildren();
        const table=document.createElement('table'); table.className='table table-striped';
        const head=document.createElement('tr'); ['ID','Name','Email','Course','Actions'].forEach(v=>cell(head,v)); table.appendChild(head);
        students.forEach(function(s) {
            const row=document.createElement('tr'); [s.id,s.name,s.email,s.course].forEach(v=>cell(row,v));
            const td=document.createElement('td');
            const edit=document.createElement('button'); edit.className='btn btn-sm btn-outline-primary me-2'; edit.textContent='Edit';
            edit.onclick=function(){ document.getElementById('action').value='edit'; document.getElementById('id').value=s.id; document.getElementById('studentName').value=s.name; document.getElementById('studentEmail').value=s.email; document.getElementById('studentCourse').value=s.course; };
            const del=document.createElement('button'); del.className='btn btn-sm btn-outline-danger'; del.textContent='Delete';
            del.onclick=async function(){ if(!confirm('Delete student?'))return; const data=new FormData(form); data.set('action','delete'); data.set('id',s.id); await save(data); };
            td.append(edit,del); row.appendChild(td); table.appendChild(row);
        }); records.appendChild(table);
    } catch(e) { statusBox.textContent='Unable to load students.'; }
}
async function save(data) {
    statusBox.textContent='Saving...';
    try {
        const response=await fetch('backend/api_students.php',{method:'POST',body:data}); const result=await response.json();
        statusBox.textContent=result.message || result.error;
        if(response.ok){form.reset();document.getElementById('action').value='add';document.getElementById('id').value='0';await loadStudents();}
    } catch(e){statusBox.textContent='Request failed.';}
}
form.addEventListener('submit',function(e){e.preventDefault();save(new FormData(form));}); loadStudents();
