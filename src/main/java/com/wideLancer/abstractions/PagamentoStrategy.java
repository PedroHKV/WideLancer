package com.wideLancer.abstractions;

import com.wideLancer.models.Produto;

public interface PagamentoStrategy {
    public boolean pagar(double valor, Produto produto);
}
