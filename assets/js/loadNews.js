fetch('/dynamic-api/news.php')
 .then(r=>r.json())
 .then(items=>{
   const list=document.getElementById('news-list');
   list.innerHTML='';
   items.forEach(n=>{
     const div=document.createElement('div');
     div.className='news-item d-flex gap-3 mb-4';
     div.innerHTML=`
       <img src="/dogpanel/uploads/news/${n.image||'noimg.png'}" class="rounded" style="width:160px;height:110px;object-fit:cover;">
       <div>
        <h3>${n.title}</h3>
        <p>${n.body||''}</p>
        <small class="text-muted">${n.created_at}</small>
       </div>`;
     list.appendChild(div);
   });
 });
