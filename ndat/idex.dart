class Cliente {
String nome;
String cpf;
Cliente({this.nome, this.cpf});
}

class Produto {
int codigo;
String nome;
double preco;
double desconto;
Produto({this.codigo, this.nome, this.preco, this.desconto = 0});
double get precoComDesconto {
return preco - ((desconto / 100) * preco);
}
}

import "./produto.dart";
class VendaItem {
Produto produto;
int quantidade;
double _preco;
VendaItem({this.produto, this.quantidade = 1});
double get preco {
if (produto != null && _preco == null) {
this._preco = produto.precoComDesconto;
}
return this._preco;
}
set preco(double novoPreco) {
if (novoPreco > 0) this._preco = novoPreco;
}
}

import './cliente.dart';
import './venda_item.dart';
class Venda {
Cliente cliente;
List<VendaItem> itens;
Venda({this.cliente, this.itens = const []});
double get valorTotal {
return itens
.map((item) => item.preco * item.quantidade)
.reduce((t, a) => t + a);
/*este método equivale a passar item
por item da lista, e somando seus valores */

}
}