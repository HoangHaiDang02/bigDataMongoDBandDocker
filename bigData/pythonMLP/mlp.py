import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score
from sklearn.model_selection import KFold
from joblib import dump

data = pd.read_csv('test_2.csv')

# Chọn các cột đặc trưng
features = ['toan1', 'ly1', 'hoa1', 'sinh1', 'van1', 'su1', 'dia1', 'anh1',
            'toan2', 'ly2', 'hoa2', 'sinh2', 'van2', 'su2', 'dia2', 'anh2']

X = data[features]
y = data['label']

# Chuyển đổi nhãn sang dạng số
label_encoder = LabelEncoder()
y = label_encoder.fit_transform(y)

# Khởi tạo k-fold cross-validation với k = 5
kfold = KFold(n_splits=5, shuffle=False)
# Tạo danh sách để lưu trữ độ chính xác từ từng fold
accuracies = []
# Lặp qua từng fold và huấn luyện/đánh giá mô hình
for train_index, test_index in kfold.split(X,y):
    X_train, X_test = X.iloc[train_index], X.iloc[test_index]
    y_train, y_test = y[train_index], y[test_index]
    # Xây dựng mô hình MLP
    mlp = MLPClassifier(hidden_layer_sizes=500)
    # Huấn luyện mô hình
    mlp.fit(X_train, y_train)
    # Đánh giá mô hình trên dữ liệu kiểm tra
    y_pred = mlp.predict(X_test)
    # Tính toán độ chính xác và lưu vào danh sách độ chính xác
    accuracy = accuracy_score(y_test, y_pred)
    accuracies.append(accuracy)

# In ra độ chính xác cao nhất từ các fold
max_accuracy = max(accuracies)
print("Độ chính xác cao nhất:", max_accuracy*100, "%")

# Tạo mô hình với độ chính xác cao nhất
best_model_index = accuracies.index(max_accuracy)
best_train_indices, best_test_indices = list(kfold.split(X,y))[best_model_index]
X_train_best, X_test_best = X.iloc[best_train_indices], X.iloc[best_test_indices]
y_train_best, y_test_best = y[best_train_indices], y[best_test_indices]

best_mlp = MLPClassifier(hidden_layer_sizes=500)
best_mlp.fit(X_train_best, y_train_best)

dump(best_mlp, 'trainModel.joblib')



