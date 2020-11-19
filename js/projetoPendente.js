const confirmarProjetoPendente = (projeto, elementoProjeto) => {
  // Mensagem de confirmação
  const confirmarMensagem = `Você tem certeza quer confirmar: "${projeto.title}"`;
  if (window.confirm(confirmarMensagem)) {
    console.log('Confirmar projeto: ', projeto, elementoProjeto);
    // PROJETO: Remover projeto da lista projeto

    // Remover elemento da tela
    elementoProjeto.remove();
  }
};

const construirProjetoItem = (projeto) => {
  // Encontrar o template da lista projetos
  const ItemTemplate = document.querySelector('#ItemTemplate');
  if (!ItemTemplate) return null;

  // Clonar template
  const ItemFragment = ItemTemplate.content.cloneNode(true);
  console.log(ItemFragment);

  const elementoProjeto = ItemFragment.querySelector('li');
  if (elementoProjeto) {
    elementoProjeto.setAttribute('data-projeto-id', projeto.id.toString());
  }

  console.log(elementoProjeto);

  const confirmarProjeto = elementoProjeto.querySelector('#confirmarProjeto');
  if (confirmarProjeto) {
    confirmarProjeto.addEventListener(
      'click',
      () => confirmarProjetoPendente(projeto, elementoProjeto)
    );
    confirmarProjeto.removeAttribute('id');
  }

  return elementoProjeto;
}

const renderizarListaProjeto = (listaProjeto) => {
  if (!Array.isArray(listaProjeto)) return;
  
  const listaProjetoElemento = document.querySelector('#lista-projeto');
  if (!listaProjetoElemento) return;

  for (const projeto of listaProjeto) {
    const projetoItemElemento = construirProjetoItem(projeto);

    listaProjetoElemento.appendChild(projetoItemElemento);
  }
};

const listaProjeto = [
  {
    id: 1,
    title: 'AUTOR PROJETO 1 - TÍTUTLO PROJETO 1',
  },
  {
    id: 2,
    title: 'AUTOR PROJETO 2 - TÍTUTLO PROJETO 2',
  }
];
renderizarListaProjeto(listaProjeto);




