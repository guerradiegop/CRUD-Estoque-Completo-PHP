// O JavaScript melhora a interface. Todas as validações importantes são repetidas no PHP.
document.querySelectorAll('[data-toggle-password]').forEach(botao=>{
  botao.addEventListener('click',()=>{
    const campo=document.getElementById(botao.dataset.togglePassword);
    campo.type=campo.type==='password'?'text':'password';
    botao.textContent=campo.type==='password'?'Mostrar':'Ocultar';
  });
});
document.querySelectorAll('form[data-confirm]').forEach(form=>{
  form.addEventListener('submit',e=>{if(!window.confirm(form.dataset.confirm))e.preventDefault();});
});
document.querySelectorAll('.needs-validation').forEach(form=>{
  form.addEventListener('submit',event=>{
    if(!form.checkValidity()){event.preventDefault();event.stopPropagation();}
    form.classList.add('was-validated');
  });
});
const observacao=document.querySelector('[data-counter]');
if(observacao){
  const contador=document.getElementById(observacao.dataset.counter);
  const atualizar=()=>{contador.textContent=observacao.value.length+'/255';};
  observacao.addEventListener('input',atualizar);atualizar();
}
const previa=document.getElementById('saldo-previa');
if(previa){
  const tipo=document.getElementById('tipo'),qtd=document.getElementById('quantidade');
  const atualizar=()=>{
    const saldo=Number(previa.dataset.saldo),n=Number(qtd.value);
    if(!qtd.value||!Number.isInteger(n)||n<=0){previa.textContent='—';return;}
    const novo=tipo.value==='entrada'?saldo+n:saldo-n;
    previa.textContent=novo+' unidades'+(novo<0?' (insuficiente!)':'');
    previa.classList.toggle('text-danger',novo<0);
  };
  [tipo,qtd].forEach(el=>el.addEventListener('input',atualizar));
}
