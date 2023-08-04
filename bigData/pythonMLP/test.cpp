#include<iostream>
#include<string>
using namespace std;

int KT_So(char n) {
    return n - 'A';
}

char KT_Char(int n)
{
    return 'A' + n; 
}

std::string xorEncrypt(const std::string& plaintext, const std::string& key)
{
    std::string ciphertext;
    size_t keyLength = key.length();

    for (size_t i = 0; i < plaintext.length(); i += keyLength)
    {
        std::string block = plaintext.substr(i, keyLength);

        for (size_t j = 0; j < block.length(); j++)
        {
            block[j] ^= key[j];
        }

        ciphertext += block;
    }

    return ciphertext;
}

bool ktra_input(const std::string& a)
{
    for (size_t i = 0; i < a.size(); i++)
    {
        char tmp = a[i];
        if ((tmp < 'a' && tmp > 'z') || (tmp < 'A' && tmp > 'Z'))
        {
            return false;
        }
    }
    return true;
}

int main()
{
    std::string a;
    char k;

    do {
        std::cout << "Nhap plaintext: ";
        std::getline(std::cin, a);
    } while (!ktra_input(a) || a.empty());

    cout << "Nhap K: "; cin>> k;

    string matma;
    for (int i = 0; i < a.size(); i++)
    {
        matma += KT_Char(KT_So(a[i])+KT_So(k));
    }

    

    // In ra chuỗi đã mã hóa
    std::cout << "Chuoi da ma hoa: " << matma << std::endl;

    return 0;
}