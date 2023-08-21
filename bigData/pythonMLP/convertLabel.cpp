#include <iostream>
#include <fstream>
#include <sstream>
#include <string>
#include <vector>
#include <algorithm>

using namespace std;


void writeToCSV(const std::string& filename, const std::string& value)
{
    std::ofstream file(filename, std::ios::app);
    file << value << "\n";
    file.close();
}

void readCSV(const std::string& filename) {
    std::ifstream file(filename);
    if (!file.is_open()) {
        std::cout << "Không thể mở file." << std::endl;
        return;
    }

    std::string line;
    while (std::getline(file, line)) {
        std::vector<std::string> row;
        std::stringstream ss(line);
        std::string cell;

        while (std::getline(ss, cell, ',')) {
            row.push_back(cell);
        }

        std::vector <double> valuesOfRow;

        // Xử lý dữ liệu của mỗi hàng ở đây
        // Ví dụ: In ra các giá trị trong hàng
        for (size_t i = 0; i < row.size(); ++i) {
            valuesOfRow.push_back(std::stod(row[i]));
        }

        double max = valuesOfRow[0];
        double index;
        for (size_t i = 1; i < valuesOfRow.size(); ++i) {
            if (valuesOfRow[i] > max) {
                max = valuesOfRow[i];
            }
        }


        for (size_t i = 0; i < valuesOfRow.size(); i++)
        {
            if (valuesOfRow[i] == max) {
                index =  i;

                break;
            }
        }

        std :: cout << index;


        std::cout << std::endl;
    }

    file.close();
}

int main() {
    std::string filename = "result.csv";
    readCSV(filename);

    return 0;
}
