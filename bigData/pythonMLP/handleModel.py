from joblib import load

getModel = load('/home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/trainModel.joblib')

file_part = '/home/danghh/demo/bigDataMongoDBandDocker/bigData/datainrequest.txt'

arrayInput = []
arrayPredict = []
arrayResult = []

with open(file_part, 'r') as file:
    lines = file.readlines()
    for line in lines:
        string_data = line.strip()
        # Tách chuỗi thành một danh sách các chuỗi con, sử dụng dấu phẩy làm delimiter
        string_list = string_data.split(',')
        # Chuyển các chuỗi thành các số nguyên trong danh sách mới
        integer_list = [int(x) for x in string_list]
        arrayInput.append(integer_list)

for value in arrayInput:
    result = getModel.predict([value])
    arrayPredict.append(result[0])

# Merge các phần tử của hai mảng
for i in range(len(arrayInput)):
    arrayInput[i].extend([arrayPredict[i]])
    # Thêm mảng con vào mảng arrayPredict
    arrayResult.append(arrayInput[i])

# In kết quả
print(arrayResult)

file_part_out = '/home/danghh/demo/bigDataMongoDBandDocker/bigData/outputdata.txt'
with open(file_part_out, 'w') as file:
    for value in arrayResult:
        stringOut = str(value).replace("[", "").replace("]", "").replace(" ", "")
        file.write(stringOut+"\n")

print("write file successfully")


# bai toan
#     -bai toan input - output, MUC TIEU
#     -docker vs mongodb
#     -MLP VS KFOLD






