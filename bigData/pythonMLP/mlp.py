import pandas as pd
from sklearn.neural_network import MLPClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score
from sklearn.model_selection import KFold
from joblib import dump

data = pd.read_csv('/home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/test_2.csv')

features = ['toan1', 'ly1', 'hoa1', 'sinh1', 'van1', 'su1', 'dia1', 'anh1',
            'toan2', 'ly2', 'hoa2', 'sinh2', 'van2', 'su2', 'dia2', 'anh2']
X = data[features]
y = data['label']

label_encoder = LabelEncoder()
y = label_encoder.fit_transform(y)

kfold = KFold(n_splits=5, shuffle=False)
accuracies = []
for train_index, test_index in kfold.split(X,y):
    X_train, X_test = X.iloc[train_index], X.iloc[test_index]
    y_train, y_test = y[train_index], y[test_index]
    mlp = MLPClassifier(hidden_layer_sizes=500, random_state=0)
    mlp.fit(X_train, y_train)
    y_pred = mlp.predict(X_test)
    accuracy = accuracy_score(y_test, y_pred)
    accuracies.append(accuracy)

max_accuracy = max(accuracies)
best_model_index = accuracies.index(max_accuracy)
best_train_indices, best_test_indices = list(kfold.split(X,y))[best_model_index]
X_train_best, X_test_best = X.iloc[best_train_indices], X.iloc[best_test_indices]
y_train_best, y_test_best = y[best_train_indices], y[best_test_indices]
best_mlp = MLPClassifier(hidden_layer_sizes=500, random_state=0)
best_mlp.fit(X_train_best, y_train_best)
dump(best_mlp, 'trainModel.joblib')



