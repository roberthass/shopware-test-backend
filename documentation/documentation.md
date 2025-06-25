# Dokumentation

## 2. Shopware mittels Docker aufsetzen

Ich habe mich wegen der Einfachheit für das dockware Image entschieden mit dem play Tag. 
Dort ist bereits Shopware 6 und alles enthalten, was Shopware zum Laufen braucht. 
Ebenso ist es vorkonfiguriert und enthält bereits Produkte.
Der Store von Shopware ist unter http://localhost erreichbar und die Administration unter http://localhost/admin. 

### Admin Zugangsdaten
- User: admin
- Passwort: shopware


## 1. Symfony Backend aufsetzen

Ich habe mich dafür entschieden die Zweite Aufgabe, vor der ersten zu machen da die zweite Aufgabe komplett für sich alleine steht und die Voraussetzung für alle weiteren Aufgaben ist.

Ich habe mich für Symfony 7.3 entschieden, weil es die aktuellste Version ist und es "nur" ein Demoprojekt ist.
Bei einer Entscheidung für ein Produktiv-System sollte man abwägen, ob die LTS (aktuell 6.4) nicht besser geeignet. 
Oder ob man eine Halbjährlichen Maintenance/Update Zyklus mitmachen kann. 
Ebenso wäre API-Platform für diese Aufgabe eine denkbare Lösung gewesen, aber ich denke nicht sehr aussagekräftig.

Mein Basis-Symfony Backend enthält bereits das symfony/test-pack als dev Abhängigkeit damit von Anfang an Test geschrieben werden können.

Nach dem Aufsetzen des Basis-Symfony-Backends würde ich mich als Nächstes um eine CI/CD Pipeline kümmern. 
Damit mein Projekt bei jedem Commit automatisch getestet wird und es auch auf eine mögliche Dev- oder Staging-Umgebung ausgerollt werden kann ohne manuellen Aufwand. 

## 3. Verbindung zwischen Symfony-Backend und Shopware herstellen

Ich habe mich für den Http Client von Symfony entschieden da er für diese Bewerberaufgabe die meisten Möglichkeiten und Flexibilität bietet.
Man hätte hier auch die guzzlehttp/guzzle Library nehmen können die OAuth2 bereits per Middleware unterstützt. 
Des Weiteren hätte ich je nach Anwendungsfall auch nochmal das shopware-php-sdk evaluiert, das einen Großteil der Shopware API bereits abstrahiert.

Ich habe mich für einen angeschlossenen Cache im Authenticator entschieden um nicht bei jedem Request den Token neu abholen zu müssen und damit die API stateless bleibt.
Die BaseUrl zu Shopware und die Credentials werden aus Environment Variablen gelesen damit es keine Codeänderung und/oder Deployment geben muss, wenn sich diese ändern sollten.

Ich habe die Integrationstests nur exemplarisch für den Authenticator Service gemacht und die restlichen Integrationstest aus Zeitgründen weg gelassen.
