//
//  RZMyRidesViewController.m
//  Rizedu
//
//  Created by Tao Xie on 11/3/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZMyRidesViewController.h"

@interface RZMyRidesViewController () {
    
}
@property (nonatomic, weak) IBOutlet UITableView *tableView;
@property (nonatomic, weak) IBOutlet UIGlossyButton *lateButton;
@property (nonatomic, weak) IBOutlet UIGlossyButton *cancelButton;
@end

@implementation RZMyRidesViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"My Rides";
        UIImage *slideImage = [UIImage imageNamed:@"menu.png"];
        UIBarButtonItem *slideButtonItem = [[UIBarButtonItem alloc] initWithImage:slideImage style:UIBarButtonItemStylePlain target:self.navigationController action:@selector(popViewControllerAnimated:)];
        self.navigationItem.leftBarButtonItem = slideButtonItem;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view from its nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)deleteRide:(NSString*)rideId andFbId:(NSString*)fbId {
    // http://www.ridezu.com/ridezu/api/v/1/rides/search/fbid/500012114/driver
    NSString *path = [NSString stringWithFormat:@"ridezu/api/v/1/rides/rideid/%@/fbid/%@", rideId, fbId];
    MKNetworkOperation* op = [[RZGlobalService singleton].ridezuEngine operationWithPath:path params:nil httpMethod:@"DELETE" ssl:NO];
    
    [op onCompletion:^(MKNetworkOperation *completedOperation) {
        NSDictionary *json = [op responseJSON];
        NSLog(@"deleteRide %@ of FbId:%@, response: %@", rideId, fbId, json);
    }
             onError:^(NSError *error) {
                 NSLog(@"%@", error);
             }];
    [[RZGlobalService singleton].ridezuEngine enqueueOperation: op];
}


@end
