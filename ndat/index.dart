/*Implemente as classes apresentadas nos slides
anteriores e implemente um método para receber um
pedido com 3 produtos.*/

class Pedido {
String p1;
String p2;
String p3;
Pedido({this.p1, this.nome, this.preco, this.desconto = 0});
double get precoComDesconto {
return preco - ((desconto / 100) * preco);
}
}