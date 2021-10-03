<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## API: Documentação

### EndPoint para teste:

**POST:** [/api/auth/login]()

    [body]
    - email: admin1@gmail.com
    - password: admin@123
##
**POST:** [/api/auth/logout]()

    - Authorization: [Token Bearer]
##

**POST:** [/api/empresa]()

    - Authorization: [Token Bearer]
    [body]
    - nome_fantasia
    - fone_principal
    - fone_secundario
    - numero  
    - tipo_pessoa [F,J]
    - tipo_contribuinte [1,0]    
    - tipo_cadastro
    - fone_principal
    - inscricao_estadual
    - estado
    - observacao
    - cidade
    - pais
    - cpf_cnpj
    - razao_social
    - cep
    - logradouro
    - complemento
    - bairro

##
**GET:** [/api/users]()

    - Authorization: [Token Bearer]

##
**GET:** [/api/empresas?cpf_cnpj={cpf_cnpj}&pais={pais}]()

    - Authorization: [Token Bearer]
    [params]
    - cpf_cnpj
    - nome_fantasia
    - razao_social
    - tipo_pessoa
    - tipo_contribuinte
    - tipo_cadastro
    - cidade
    - estado
    - pais

##

**GET:** [/api/verifyCnpj?cnpj={cnpj}]()

    - Authorization: [Token Bearer]

##

**DELETE:** [/api/empresa/delete?id={id}]()

    - Authorization: [Token Bearer]
    [params]
    - id 
    - cpf_cnpj

##

**PUT:** [/api/empresa/edit?id={id}]()

    - Authorization: [Token Bearer]
    [params]
    - id 
    - cpf_cnpj

##

**POST:** [api/empresa/{id}]()

    - Authorization: [Token Bearer]
    [body]
    - nome_fantasia
    - fone_principal
    - fone_secundario
    - numero  
    - tipo_pessoa [F,J]
    - tipo_contribuinte [1,0]    
    - tipo_cadastro
    - fone_principal
    - inscricao_estadual
    - estado
    - observacao
    - cidade
    - pais
    - razao_social
    - cep
    - logradouro
    - complemento
    - bairro


