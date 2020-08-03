# Microserviço para Compra de Produtos c/ Cartão de Crédito.

A proposta desse exercício é construir uma API REST para compra de produtos utilizando a forma de pagamento cartão de crédito. A API deve possibilitar todo o gerenciamento de estoque e venda de produtos.

## Arquitetura da solução: 
![Helpay](https://user-images.githubusercontent.com/20055253/89138112-d7817500-d510-11ea-9a81-9c3f10a3e49c.png)

## Estrutura do Código:

├─ api/

├─── config/

├────── core.php - Usado para configuração core

├────── database.php - Usado para conectar ao database

├─── objects/

├────── product.php - Propriedades e Métodos para as <i>queries</i> do produto.

├─── product/

├────── create.php - Cria o produto no database

├────── delete.php - Deleta o produto no database, de acordo com o <i>produt_id</i>

├────── read.php - Lê os produtos no database e os retorna em <i>JSON</i>

├────── read_one.php - Lê o produto no database de acordo com o <i>product_id</i> e trás os dados completos

├────── update.php - Atualiza a informação de um produto, de acordo com seu <i>product_id</i>

├─ Dockerfile

├─ README.md








## Endpoints:

#### 1. Adicionar produtos ao estoque: 

[POST] /api/products
```
{
    "name" : "Computador",
    "amount" : 450.0,
    "qty_stock" : 5
}
```

#### 2. Listar produtos disponíveis do estoque:

[GET] /api/products

#### 3. Detalhar um produto do estoque:

[GET] /api/product/product_id

#### 4. Comprar um produto do estoque:

[POST] /api/purchase

```
{
	"product_id":1,
	"quantity_purchased":1,
	"card":{
		"owner":"John Doe",
		"card_number":"4111870010309393",
		"date_expiration":"12/2018",
		"flag":"VISA",
		"cvv":"123"
	}
}
```
#### 5. Remover um produto do estoque:

[DELETE] /api/product/product_id






## Integrações

A solução possui integração com o Google Drive. Quando uma compra é realizada, é gerado um arquivo <i>.xml</i> com os dados do pedido, e são salvos na <i>root</i> do mesmo. Após isso, é enviado um email para o administrador do sistema (exemplo@gmail.com) com o link do drive para download.
