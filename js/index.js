document.getElementById("note_form").onsubmit = handleAddNote;

// variable for storing notes
var notes = [];

function handleAddNote(e) {
  e.preventDefault();
  var title = document.getElementById("title").value;
  var content = document.getElementById("content").value;

  var note = {
    title: title,
    content: content,
  };
  // add note to array
  notes.push(note);

  // clear form
  document.getElementById("title").value = "";
  document.getElementById("content").value = "";
  // render notes
  renderNotes();
}

//function to render notes with delete button to html
function renderNotes() {
  var html = "";
  for (var i = 0; i < notes.length; i++) {
    html += `<div class="note">
        <h3>${notes[i].title}</h3>
        <p>${notes[i].content}</p>
        <button class='delete' onclick="deleteNote(${i})">Delete</button>
        </div>`;
  }
  document.getElementById("notes_container").innerHTML = html;
}

function deleteNote(index) {
  notes.splice(index, 1);
  renderNotes();
}
