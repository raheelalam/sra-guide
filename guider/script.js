let tutorials = [];

fetch('tutorials.json')
  .then(res => res.json())
  .then(data => {
    tutorials = data;
    renderTutorials();
  });

function renderTutorials() {
  const container = document.getElementById('tutorials');
  container.innerHTML = '';
  tutorials.forEach(t => {
    const div = document.createElement('div');
    div.innerHTML = `<h3>${t.title}</h3><strong>Topic:</strong> ${t.topic}<pre>${t.content}</pre>`;
    container.appendChild(div);
  });
}

document.getElementById('tutorialForm').addEventListener('submit', function(e){
  e.preventDefault();
  const newTutorial = {
    title: document.getElementById('title').value,
    topic: document.getElementById('topic').value,
    content: document.getElementById('content').value
  };
  
  tutorials.push(newTutorial);
  renderTutorials();
  this.reset();
});
