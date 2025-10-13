  document.querySelectorAll(".progress-bar").forEach(bar => {
    const text = bar.querySelector(".progress-text").textContent.trim();
    const [current, goal] = text.split("/").map(v => parseFloat(v.replace(/,/g, "")));
    
    if (!isNaN(current) && !isNaN(goal) && goal > 0) {
      const percentage = Math.min((current / goal) * 100, 100); // cap at 100%
      bar.querySelector(".progress").style.width = percentage + "%";
    }
  });