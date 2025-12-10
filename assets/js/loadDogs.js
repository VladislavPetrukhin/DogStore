fetch('/dynamic-api/dogs.php')
.then(r=>r.json())
.then(dogs=>{
 const c=document.getElementById('dogs-container');
 if(!c) return;
 c.innerHTML='';
 dogs.forEach(d=>{
   const img=d.main_photo?`/dogpanel/uploads/dogs/${d.main_photo}`:'/assets/img/no-photo.png';
   const el=document.createElement('div');
   el.className='col-12 col-sm-6 col-lg-4';
   el.innerHTML=`<article class="card p-3">
      <img src="${img}" class="card-img-top mb-3" style="height:260px;object-fit:cover;">
      <h3>${d.name}</h3>
      <span class="badge bg-primary mb-2">${d.breed||'Не указана'}</span>
      <p><strong>Цена:</strong> ${d.price||'—'}</p>
   </article>`;
   c.appendChild(el);
 });
});