#pessoal primeiro instala a biblioteca
#pip install docx2pdf
#pra usar caso nao tenha internet nem word instalado
import os
from docx2pdf import convert

def converter_docx_para_pdf(arquivo_docx):
    """
    Converte um arquivo .docx para .pdf
    
    Args:
        arquivo_docx (str): Caminho do arquivo .docx
    """
    try:
        # Verifica se o arquivo existe
        if not os.path.exists(arquivo_docx):
            print(f"❌ Erro: O arquivo '{arquivo_docx}' não foi encontrado.")
            return False
        
        # Verifica se é um arquivo .docx
        if not arquivo_docx.lower().endswith('.docx'):
            print(f"❌ Erro: O arquivo precisa ser .docx")
            return False
        
        # Gera o nome do arquivo PDF (mesmo nome, extensão .pdf)
        arquivo_pdf = arquivo_docx.replace('.docx', '.pdf').replace('.DOCX', '.pdf')
        
        # Converte o arquivo
        print(f"🔄 Convertendo: {arquivo_docx}")
        convert(arquivo_docx, arquivo_pdf)
        print(f"✅ Sucesso! PDF criado: {arquivo_pdf}")
        return True
        
    except Exception as e:
        print(f"❌ Erro ao converter: {e}")
        return False


def converter_pasta_completa(pasta):
    """
    Converte todos os arquivos .docx de uma pasta para .pdf
    
    Args:
        pasta (str): Caminho da pasta com arquivos .docx
    """
    try:
        # Verifica se a pasta existe
        if not os.path.exists(pasta):
            print(f"❌ Erro: A pasta '{pasta}' não foi encontrada.")
            return
        
        # Lista todos os arquivos .docx na pasta
        arquivos_docx = [f for f in os.listdir(pasta) if f.lower().endswith('.docx')]
        
        if not arquivos_docx:
            print(f"⚠️ Nenhum arquivo .docx encontrado na pasta '{pasta}'")
            return
        
        print(f"📂 Encontrados {len(arquivos_docx)} arquivo(s) .docx\n")
        
        # Converte cada arquivo
        convertidos = 0
        for arquivo in arquivos_docx:
            caminho_completo = os.path.join(pasta, arquivo)
            if converter_docx_para_pdf(caminho_completo):
                convertidos += 1
            print()  # Linha em branco entre conversões
        
        print(f"🎉 Conversão concluída! {convertidos}/{len(arquivos_docx)} arquivo(s) convertido(s).")
        
    except Exception as e:
        print(f"❌ Erro ao processar pasta: {e}")


# ============================================================
# EXEMPLOS DE USO
# ============================================================

if __name__ == "__main__":
    
    # OPÇÃO 1: Converter um arquivo específico
    # Descomente a linha abaixo e coloque o caminho do seu arquivo
    # converter_docx_para_pdf("meu_documento.docx")
    
    # OPÇÃO 2: Converter todos os arquivos de uma pasta
    # Descomente a linha abaixo e coloque o caminho da sua pasta
    # converter_pasta_completa("./documentos")
    
    # OPÇÃO 3: Menu interativo (descomente o bloco abaixo)
    print("=" * 50)
    print("🔄 CONVERSOR DOCX PARA PDF")
    print("=" * 50)
    print("\n1 - Converter um arquivo específico")
    print("2 - Converter todos os arquivos de uma pasta")
    print("0 - Sair\n")
    
    opcao = input("Escolha uma opção: ")
    
    if opcao == "1":
        arquivo = input("\nDigite o caminho do arquivo .docx: ")
        converter_docx_para_pdf(arquivo)
    
    elif opcao == "2":
        pasta = input("\nDigite o caminho da pasta: ")
        converter_pasta_completa(pasta)
    
    elif opcao == "0":
        print("👋 Até logo!")
    
    else:
        print("❌ Opção inválida!")